#!/bin/bash
# wait-for-it.sh

host="$1"
shift
cmd="$@"

until mysqladmin ping -h "$host" --silent; do
  echo "MySQL ainda não está pronto. Tentando novamente em 5 segundos..."
  sleep 5
done

exec $cmd
