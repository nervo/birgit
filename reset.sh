app/console doctrine:database:drop --force && \
app/console doctrine:database:create && \
app/console doctrine:schema:create && \
#app/console doctrine:fixtures:load -n
app/console birgit:test:fixtures
