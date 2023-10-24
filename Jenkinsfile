pipeline {
    agent any

 /*   environment {
    GITHUB_USERNAME = credentials('GitHubCredentials').babacaar
    GITHUB_ACCESS_TOKEN = credentials('GitHubCredentials').Vakrib#84
}*/


    stages {
        stage('Checkout from GitHub') {
            steps {
                // Utilisez git pour récupérer le script de sauvegarde depuis GitHub
                checkout([$class: 'GitSCM', branches: [[name: '*/master']], doGenerateSubmoduleConfigurations: false, extensions: [], submoduleCfg: [], userRemoteConfigs: [[url: 'https://babacaar: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@github.com/babacaar/Projet_Raspberry/']]])
            }
        }

        stage('Sauvegarde de la base de données') {
            steps {
                // Assurez-vous que le script de sauvegarde est exécutable
                sh 'chmod +x DB-backup/backup.sh'
                sh '/DB-backup/backup.sh'  // Exécute le script de sauvegarde
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
                sh 'cp sauvegarde.sql ./root/jenkins/mesBackup/'

                // Utilisez git pour ajouter, valider et pousser la sauvegarde sur GitHub
                sh 'git add .'
                sh 'git commit -m "Sauvegarde automatique"'
                sh 'git push'
            }
        }
    }
}
