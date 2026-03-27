# Prompt Repository – DevGenius Solutions

## Contexte du Projet
DevGenius Solutions est une agence Full-Stack intégrant l'IA dans ses workflows.  
Les développeurs utilisent des LLM (Large Language Models) pour générer du code, créer des scripts ou rédiger des documentations.  
Problème : Beaucoup de prompts performants se perdent dans l’historique des chats.  
Mission : Créer une plateforme interne de **Knowledge Management** pour stocker, catégoriser et réutiliser ces prompts précieux.

---

## Objectifs du Projet

### Objectifs Techniques
- Concevoir une **base de données relationnelle normalisée**.
- Mettre en place une **authentification sécurisée**.
- Maîtriser le cycle **CRUD** avec **PHP/MySQL**.
- Sécuriser les données via `password_hash()` et **Prepared Statements**.

### User Stories
- **Développeur** : Créer un compte pour accéder à la bibliothèque.
- **Développeur** : Ajouter un prompt avec titre et catégorie.
- **Développeur** : Filtrer les prompts par thématique (Code, Marketing, SQL, etc.).
- **Admin** : Gérer les catégories et voir les contributeurs les plus actifs.

---

## Spécifications Techniques

### Base de données
Tables principales :
1. **users** – informations des utilisateurs.
2. **categories** – thématiques des prompts.
3. **prompts** – prompts liés à un auteur et une catégorie.

Relations :
- `users.id` → `prompts.user_id`
- `categories.id` → `prompts.category_id`

### Backend PHP
- **db.php** : connexion centralisée via PDO.
- **Prepared Statements** pour sécuriser les requêtes.
- **Sessions PHP** pour gérer l'état utilisateur.

### Sécurité
- Mot de passe : `password_hash()` à l’inscription.
- Validation serveur : champs obligatoires et formats corrects.
- Prévention SQL Injection : aucune variable PHP directement dans les requêtes.

---

## Installation
# CREATION DE BASE DE DONNER
- prompts.sql aussi importer dans votre base de donner


1. Cloner le dépôt :
```bash
git clone  https://github.com/kirawilik/prompts.git
cd prompt-repository
