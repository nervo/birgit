bin/console doctrine:database:drop --force && \
bin/console doctrine:database:create && \
bin/console doctrine:schema:create --em=birgit && \
bin/console doctrine:schema:create --em=birgit_task && \
bin/console birgit:test:fixtures
