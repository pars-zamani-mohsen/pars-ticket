#!/bin/bash

parse_git_branch() {
    git branch 2> /dev/null | sed -e '/^[^*]/d' -e 's/* \(.*\)/(\1)/'
}

cat >> ~/.bashrc <<'EOF'
# Git Branch show
force_color_prompt=yes
color_prompt=yes

parse_git_branch() {
    git branch 2> /dev/null | sed -e '/^[^*]/d' -e 's/* \(.*\)/(\1)/'
}

if [ "$color_prompt" = yes ]; then
    PS1='${debian_chroot:+($debian_chroot)}\[\033[01;32m\]\u@\h\[\033[00m\]:\[\033[01;34m\]\w\[\033[01;31m\]$(parse_git_branch)\[\033[00m\]\$ '
else
    PS1='${debian_chroot:+($debian_chroot)}\u@\h:\w$(parse_git_branch)\$ '
fi
unset color_prompt force_color_prompt

# Aliases
alias pa='php artisan'
EOF

# Load bashrc
source ~/.bashrc

cd /var/www/html

echo "Waiting for database connection..."
max_tries=30
counter=0
until php artisan db:monitor > /dev/null 2>&1; do
    counter=$((counter + 1))
    if [ $counter -gt $max_tries ]; then
        echo "Error: Failed to connect to database after $max_tries attempts"
        exit 1
    fi
    echo "Attempting to connect to database... ($counter/$max_tries)"
    sleep 1
done

echo "Running migrations..."
php artisan migrate --force || { echo "Migration failed"; exit 1; }

echo "Running seeders..."
php artisan db:seed --force || { echo "Seeding failed"; exit 1; }

echo "Clearing cache..."
php artisan config:clear
php artisan route:clear

echo "Starting supervisor..."
exec /usr/bin/supervisord -n