# projektname

## Core-Submodule:
git submodule add git@github.com:HTML42/H_xtreme-webframework-2.git xtreme
### Update Submodules:
git submodule update


##Restart subgit-folders after clone:
git rm -rf xtreme && git submodule add -f git@github.com:HTML42/H_xtreme-webframework-2.git xtreme &&
git rm -rf plugins &&
    git submodule add -f git@github.com:HTML42/H_X-Plugin-login.git plugins/login &&
    git submodule add -f git@github.com:HTML42/H_X-Plugin-jsondb.git plugins/jsondb &&
git submodule update


## Plugin-Submodule Login:
git submodule add git@github.com:HTML42/H_X-Plugin-login.git plugins/login

## Plugin-Submodule JSON-DB:
git submodule add git@github.com:HTML42/H_X-Plugin-jsondb.git plugins/jsondb
