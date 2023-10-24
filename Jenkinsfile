pipeline {
    agent any

    stages {
        stage('Checkout from GitHub') {
            steps {
                // Utilisez git pour récupérer le script de sauvegarde depuis GitHub
                checkout([$class: 'GitSCM', branches: [[name: '*/main']], doGenerateSubmoduleConfigurations: false, extensions: [], submoduleCfg: [], userRemoteConfigs: [[url: 'https://github.com/babacaar/Projet_Raspberry.git']]])
            }
        }

        stage('Sauvegarde de la base de données') {
            steps {
                sh './backup.sh'  // Exécute le script de sauvegarde
            }
        }
        stage('Archiver les sauvegardes') {
            steps {
                archiveArtifacts artifacts: 'sauvegarde.sql', allowEmptyArchive: true
            }
        }

        stage('Commit and Push to GitHub') {
            steps {
                // Copiez la sauvegarde dans le répertoire du référentiel local
                sh 'cp sauvegarde.sql ./root/jenkins/mesBackup'

                // Utilisez git pour ajouter, valider et pousser la sauvegarde sur GitHub
                sh 'git add .'
                sh 'git commit -m "Sauvegarde automatique"'
                sh 'git push'
            }
        }
    }
}
