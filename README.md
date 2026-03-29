
# 🛠️ InfoTools - CRM & Gestion Commerciale (Mission 2)

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

**InfoTools** est une solution complète de gestion de la relation client (CRM) développée avec le framework **Laravel**. Ce projet gère les prospects, les clients et la facturation pour les commerciaux de la société Info-Tools.

---

## 📋 Présentation du Projet
L'application fournit aux commerciaux un outil robuste pour :
* **Tableau de bord** : Vue immédiate sur les rendez-vous à venir.
* **Gestion CRM** : CRUD complet sur les Clients, Prospects et Rendez-vous.
* **Catalogue & Ventes** : Consultation des produits et historique des achats.
* **API REST** : Interface pour l'application mobile.

---

## 🗄️ Base de Données & Jeu d'essai
Pour une installation rapide (en moins de 5 minutes) lors de la présentation :
1. **Importation** : Importez le fichier `infotools.sql` dans votre gestionnaire de BDD (PHPMyAdmin, etc.).
2. **Configuration** : Copiez `.env.example` vers `.env` et ajustez les accès DB.
3. **Initialisation** : Lancez `php artisan key:generate` pour activer l'application.

*Le jeu d'essai contient des données multi-commerciaux pour tester les droits d'accès.*

---

## 🔐 Sécurité & Exigences Qualité (Mission 2)

### 1. Contrôle d'accès & Anti-IDOR (Cloisonnement)
Chaque commercial possède son propre portefeuille. Grâce aux **Laravel Policies**, un commercial ne peut **ni lire, ni modifier, ni supprimer** les données d'un collègue.
* *Fichier clé : `app/Policies/ClientPolicy.php`.*

### 2. Journalisation d'Audit (Logs BDD)
Toutes les actions critiques (INSERT/UPDATE/DELETE) sont tracées : `user_id`, `action`, `description`, `ip_address`.
* *Usage : Traçabilité complète des modifications sur les tables critiques.*

### 3. Protection de l'API
* **Validation** : Rejet des données malformées (Code 422).
* **Throttling** : Limitation à 60 requêtes/minute pour contrer le brute-force (Code 429).

---

## 🧪 Tests Automatisés (Livrable Obligatoire)

La suite de tests garantit le respect du cahier des charges de la Mission 2 :
* **ValidationTest** : Vérifie l'intégrité des entrées.
* **IDORTest** : Vérifie le blocage des accès non autorisés (Attendu : 403).
* **LoggingTest** : Vérifie la création automatique des logs d'audit.

**Lancer la suite de tests :**
```bash
php artisan test --filter ClientApiSecurityTest
