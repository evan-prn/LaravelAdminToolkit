<p align="center">
  <img src="https://img.shields.io/packagist/v/evan-prn/laravel-admin-toolkit?style=flat-square" alt="Latest Version">
  <img src="https://img.shields.io/github/workflow/status/evan-prn/LaravelAdminToolkit/Tests/main?style=flat-square" alt="Tests Status">
  <img src="https://img.shields.io/packagist/l/evan-prn/laravel-admin-toolkit?style=flat-square" alt="License">
</p>

# Laravel Admin Toolkit

**Outils avancés d'administration pour Laravel 10 & 11 — Artisan Power Pack 🚀**

> Un package professionnel regroupant toutes les commandes utiles d’administration et de maintenance pour tes projets Laravel.

---

## 🚀 Fonctionnalités incluses

- 🔐 `db:truncate` — Truncate sécurisé avec :
  - Confirmation avant exécution
  - Simulation (`--pretend`)
  - Liste des tables (`--list`)
  - Exclusion de tables protégées
  - Journalisation automatique
- 👤 `user:create` — Création rapide d’utilisateur via Artisan.
- 🔑 `user:assign` — Assignation de rôles et permissions, avec création automatique des rôles et permissions manquants.
- 📋 `roles:list` — Liste les rôles et permissions existants.
- 🧹 `logs:clear` — Nettoyage complet des logs Laravel.
- ✅ Compatible Laravel 10 et 11
- 🧪 Tests automatisés (Pest + Testbench)
- 🔄 CI/CD prêt à l'emploi (GitHub Actions)

---

## ⚙️ Liste des commandes artisan disponibles

| Commande | Description |
|----------|-------------|
| `db:truncate` | Truncate sécurisé de la base |
| `user:create` | Création d'utilisateur |
| `user:assign` | Assignation de rôles & permissions |
| `roles:list` | Liste des rôles & permissions existants |
| `logs:clear` | Nettoyage des fichiers de log Laravel |

---

## 📦 Installation

### 1️⃣ Pré-requis

- PHP >= 8.1
- Laravel 10 ou 11
- spatie/laravel-permission `^6.0` (automatiquement géré par composer)

### 2️⃣ Installation via Composer

```bash
composer require evan-prn/laravel-admin-toolkit
