#!/bin/bash

composer install
sed -i '/\/vendor\//d' ./.gitignore
find . -type f -name '*.gitignore' -delete
find vendor -type d -name '*.git' | xargs rm -rf

read -p "Enter a version number: " VERSION
git add vendor/*
git add app/config/*
git add web/datafiles/*
git add database/*
git add database/keys/*
git add database/globalConfig.php
git commit -m "Version bump to v$VERSION"
git tag -a -m "Tagging version v$VERSION" "v$VERSION"
git push origin --tags
echo "Bumped to v$VERSION"

