# Installation
```
git clone https://github.com/fzadelj/DemoPosts
cd DemoPosts
docker-compose up --build -d
bin/docker/composer update
bin/docker/console doctrine:database:create
bin/docker/console doctrine:migrations:migrate
```

# Load posts into the database
```
bin/docker/console vendor:typicode:fetch
```

# API usage

List posts: http://localhost:8080/api/posts

List users: http://localhost:8080/api/users

List posts for user: http://localhost:8080/api/users/2/posts?sort=id