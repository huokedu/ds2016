#!/bin/bash

# Name:        seed.sh
# Author:      Nick Schuch
# Description: Content!

curl -H "Content-Type: application/json" -X POST -d '{"title":"The 19 Most Courageous Cheeses From National Geographics History","body":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book."}' http://localhost:8080/blog
curl -H "Content-Type: application/json" -X POST -d '{"title":"12 Optical Illusions That Are Way More Important Than Work Right Now","body":"It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout."}' http://localhost:8080/blog
curl -H "Content-Type: application/json" -X POST -d '{"title":"The 43 Cutest Pastries Of The 90s","body":"It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout."}' http://localhost:8080/blog
curl -H "Content-Type: application/json" -X POST -d '{"title":"48 Cats Who Will Make You Feel Like A Genius","body":"It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout."}' http://localhost:8080/blog
