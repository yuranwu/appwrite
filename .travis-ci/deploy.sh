# echo 'Nothing to deploy right now.'

# docker buildx build --platform linux/amd64,linux/arm64 -t appwrite/env-dart-2.10:1.0.0 ./docker/environments/dart-2.10/ --push

echo '.NET 3.1...'
docker buildx build --platform linux/amd64,linux/arm64 -t appwrite/env-dotnet-3.1:1.0.0 ./docker/environments/dotnet-3.1/ --push

echo '.NET 5.0...'
docker buildx build --platform linux/amd64,linux/arm64 -t appwrite/env-dotnet-5.0:1.0.0 ./docker/environments/dotnet-5.0/ --push