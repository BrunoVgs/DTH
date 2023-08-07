echo "-----------------------------------------------------------------------------------------------------------"
echo "|  _                        _ _                                ______               ___                   |"
echo "| | |             _        | | |         _                    / _____)             / __)                  |"
echo "| | |____   ___ _| |_ _____| | | _____ _| |_ _  ___  ____    ( (____  _   _ ____ _| |__ ___  ____  _   _  |"
echo "| | |  _ \ /___|_   _|____ | | |(____ (_   _) |/ _ \|  _ \    \____ \| | | |    (_   __) _ \|  _ \| | | | |"
echo "| | | | | |___ | | |_/ ___ | | |/ ___ | | |_| | |_| | | | |   _____) ) |_| | | | || | | |_| | | | | |_| | |"
echo "| |_|_| |_(___/   \__)_____|\_)_)_____|  \__)_|\___/|_| |_|  (______/ \__  |_|_|_||_|  \___/|_| |_|\__  | |"
echo "|                                                                    (____/                      (____/  |"
echo "-----------------------------------------------------------------------------------------------------------"

## Attribution du nom du nouveau projet Symfony
echo "Quel est le nom du nouveau projet ?"
read projectName

## création du projet symfony avec composer
composer create-project symfony/skeleton:^5.4 $projectName
cd $projectName

## TWIG !
composer require twig/twig
## Extras :
composer require twig/extra-bundle

## pour faire des liens correct dans twig vers nos assets
composer require symfony/asset

## vive le debug : la barre de debug avec le backoffice de debug : profiler
composer require --dev symfony/profiler-pack

## permet au dump de ne plus être dans la page, mais dans le WebDebugToolbar
composer require --dev symfony/debug-bundle

## le maker
composer require --dev symfony/maker-bundle

# Installe Symfony Security Bundle
composer require symfony/security-bundle

# Installe Symfony Form and Validation components
composer require symfony/form symfony/validator

# Installe Symfony Routing and Translation components
composer require symfony/routing symfony/translation

## installation de tout les composants pour Doctrine
echo "x" | composer require symfony/orm-pack
## Annotations pour @Route()
composer require doctrine/annotations
## Fixture / Mixture
composer require doctrine/doctrine-fixtures-bundle 

mkdir Docs
cp ../SymfoInstall.sh Docs/

composer update

echo "-------------------------------------------------------------------------------------"
echo "|                                                                           _       |"
echo "|                                                                           ( )     |"
echo "|  ____                   __                     _           _        _ _   |/   _  |"
echo "| / ___| _   _ _ __ ___  / _| ___  _ __  _   _  (_)_ __  ___| |_ __ _| | | ___  | | |"
echo "| \___ \| | | |  _   _ \| |_ / _ \|  _ \| | | | | |  _ \/ __| __/ _  | | |/ _ \ | | |"
echo "|  ___) | |_| | | | | | |  _| (_) | | | | |_| | | | | | \__ \ || (_| | | |  __/ |_| |"
echo "| |____/ \__, |_| |_| |_|_|  \___/|_| |_|\__, | |_|_| |_|___/\__\__,_|_|_|\___| (_) |"
echo "|        |___/                           |___/                                      |"
echo "-------------------------------------------------------------------------------------"

