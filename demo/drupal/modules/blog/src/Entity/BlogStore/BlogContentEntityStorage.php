<?php

namespace Drupal\blog\Entity\BlogStore;

use Drupal\Core\Language\LanguageInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Drupal\Core\KeyValueStore\StorageBase;
use Drupal\Component\Serialization\SerializationInterface;
use Drupal\Core\Database\Query\Merge;
use Drupal\Core\Database\Connection;
use Drupal\Core\DependencyInjection\DependencySerializationTrait;

/**
 * Defines a default key/value store implementation.
 *
 * This is Drupal's default key/value store implementation. It uses the database
 * to store key/value data.
 */
class BlogContentEntityStorage extends StorageBase {

  use DependencySerializationTrait;

  /**
   * The http client.
   *
   * @var \GuzzleHttp\Client
   */
  protected $client;

  /**
   * Overrides Drupal\Core\KeyValueStore\StorageBase::__construct().
   *
   * @param string $collection
   *   The name of the collection holding key and value pairs.
   * @param \Drupal\Component\Serialization\SerializationInterface $serializer
   *   The serialization class to use.
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection to use.
   * @param string $table
   *   The name of the SQL table to use, defaults to key_value.
   */
  public function __construct($collection, \GuzzleHttp\Client $client) {
    parent::__construct($collection);
    $this->client = $client;
  }

  /**
   * {@inheritdoc}
   */
  public function has($key) {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function getMultiple(array $keys) {
    $result = $this->getAll();

    $values = array();

    foreach ($keys as $key) {
      if (isset($result[$key])) {
        $values[$key] = $result[$key];
      }
    }

    return $values;
  }

  /**
   * {@inheritdoc}
   */
  public function getAll() {
    $blogs = array();

    $request = new Request('GET', 'http://api:8080/blogs');

    try {
      $response = $this->client->send($request);
      $blogs = json_decode($response->getBody(), TRUE);
      foreach ($blogs as $id => $blog) {
        foreach ($blog as $field => $value) {
          $blogs[$id][$field] = [LanguageInterface::LANGCODE_DEFAULT => $value];
        }
        $blogs[$id]['id'] = [LanguageInterface::LANGCODE_DEFAULT => $id];
      }
    }
    catch (RequestException $e) {
      throw $e;
    }

    return $blogs;
  }

  /**
   * {@inheritdoc}
   */
  public function set($key, $values) {
    $request = new Request('POST', 'http://api:8080/blog/' . $key, [], json_encode(array(
      'title' => $values['title'][0]['value'],
      'body' => $values['body'][0]['value'],
    )));
    $request = $request->withHeader('Content-Type', 'application/json');

    try {
      $this->client->send($request);
    }
    catch (RequestException $e) {
      throw $e;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function setIfNotExists($key, $values) {
    $this->set($key, $values);
  }

  /**
   * {@inheritdoc}
   */
  public function rename($key, $new_key) {
    // Not supported.
  }

  /**
   * {@inheritdoc}
   */
  public function deleteMultiple(array $keys) {
    foreach ($keys as $key) {
      $request = new Request('DELETE', 'http://api:8080/blog/' . $key);
      try {
        $this->client->send($request);
      }
      catch (RequestException $e) {
        throw $e;
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function deleteAll() {
    $blogs = $this->getAll();
    $this->deleteAll(array_keys($blogs));
  }

}
