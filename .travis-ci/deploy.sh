# echo 'Nothing to deploy right now.'

docker buildx build --platform linux/amd64,linux/arm64,linux/386,linux/ppc64le -t appwrite/env-dart-2.10.4:1.0.0 ./docker/environments/dart-2.10.4/ --push