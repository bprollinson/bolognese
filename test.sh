#!/bin/bash

echo "Empty set"
curl -i http://localhost/entity

echo -e "\n\nEmpty count"
curl -i http://localhost/entity/count

echo -e "\n\nMissing entity"
curl -i http://localhost/entity/1

echo -e "\n\nCreating entity"
curl -i -X POST -H "Content-Type: application/json" -d '{"name":"testname"}' http://localhost/entity

echo -e "\n\nNon-empty set"
curl -i http://localhost/entity

echo -e "\n\nNon-empty count"
curl -i http://localhost/entity/count

echo -e "\n\nPresent entity"
curl -i http://localhost/entity/1

echo -e "\n\nDeleting entity"
curl -i -X DELETE http://localhost/entity/1

echo -e "\n\nPost-delete empty set"
curl -i http://localhost/entity

echo -e "\n\nPost-delete empty count"
curl -i http://localhost/entity/count

echo -e "\n\nPost-delete empty entity"
curl -i http://localhost/entity/1

echo -e "\n\nAttempting to delete again"
curl -i -X DELETE http://localhost/entity/1
