up:
	docker-compose -f infrastructure/dev/docker-compose.yml up -d
down:
	docker-compose -f infrastructure/dev/docker-compose.yml down
restart:
	docker-compose -f infrastructure/dev/docker-compose.yml restart
