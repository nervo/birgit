app/console doctrine:database:drop --force && \
app/console doctrine:database:create && \
app/console doctrine:schema:create --em=birgit && \
app/console doctrine:schema:create --em=birgit_task && \
app/console birgit:test:fixtures
