# echo 'Nothing to deploy right now.'

docker buildx build --platform linux/amd64,linux/arm64 -t appwrite/env-dart-2.10:1.0.0 ./docker/environments/dart-2.10/ --push