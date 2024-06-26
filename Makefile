help:
	cat docs/make.md

run:
	@./scripts/run.sh
start:
	@./scripts/start.sh
stop:
	@./scripts/stop.sh
unit:
	@./scripts/unit.sh
kill:
	@./scripts/kill.sh
	@./scripts/unit.sh
kill-app:
	@./scripts/kill-app.sh
kill-app-full:
	@./scripts/kill-app-full.sh
kill-db:
	@./scripts/kill-db.sh
kill-db-full:
	@./scripts/kill-db.sh
users:
	@./scripts/importUsers.sh