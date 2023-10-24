pipeline {
    agent any
    stages {
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
    }
}
