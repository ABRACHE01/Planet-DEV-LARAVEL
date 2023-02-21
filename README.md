# Planet-DEV-LARAVEL  
Planet.DEV | Développer REST API V1 avec Laravel  
### Description 
Planet.DEV est une communauté de développeurs qui se réunissent autour de la découverte et de l'exploration de l'actualité du développement. 

### Diagrams (class/ usecase /sequinse)  

link usecase diagram:    
https://lucid.app/lucidchart/18c4975f-4da5-470c-baae-7c09d0c782a0/edit?viewport_loc=-764%2C78%2C3461%2C1457%2C.Q4MUjXso07N&invitationId=inv_5bb9831b-0a9e-4ef5-9e69-b2e6c67d7396   
link sequence diagrame :    
https://lucid.app/lucidchart/772b56f6-13c0-4813-83cb-9076bc113489/edit?viewport_loc=-456%2C-22%2C3554%2C1496%2C0_0&invitationId=inv_7b937cf3-f193-4032-9b8a-12be745994aa    
link class diagram:     
https://lucid.app/lucidchart/7ebe20f7-a352-4bbc-a21c-6f7b88e7d6e0/edit?viewport_loc=-401%2C-99%2C3329%2C1401%2CHWEp-vi-RSFO&invitationId=inv_78260070-5919-494d-8372-9b1379470c3f    
### Installation steps 

1.  git clone https://github.com/medabra/Planet-DEV-LARAVEL.git   
2.  composer install   
3.  cp .env.example .env   
4.  php artisan key:generate    
5.  php artisan migrate  
6.  php artisan serve  
7. Go to link localhost:8000  

### Technologies :
Laravel, PHP, MySQL, API REST, JSON, Documentation API (POSTMAN, OPEN API ou SWAGGER).  
Authentification avec Laravel via (sanctum, jwt ou bien passport)  
Framework requise: soit Laravel ou Lumen   

## Content

--> Rules:  
	+ Everyday 1 commit at the end of the day  
	+ Live Coding (on other API technologies not used in the brief)  
	+ standard naming   

--> Main tasks:  

1- Add a User role: (User role is set by the admin, so he limits the functionalities)  
	+ Création, édition, suppression et consultation d'articles.  
	+ Création, édition, suppression et consultation de catégories. (admin)  
	+ Création, édition, suppression et consultation de tags.     
	+ Création, édition, suppression et consultation de commentaires.  

2-Documentation: (FIRST)  
	+ REST API (POSTMAN <- (Y), OPEN API ou SWAGGER).  
	+ Authentification avec Laravel via (sanctum (Y), jwt (LvCo) ou bien passport (LvCo))  

3-Responsive  

4-Diagramme UML (diagramme de cas d'utilisation, diagrame de classe et diagramme de séquence)  

--> Technologies used:  
	+ Back-end:  
		- Laravel, PHP, MySQL, API REST, JSON, API Testing(POSTMAN, OPEN API ou SWAGGER).  
		- Sanctum, Jwt ou bien passport  
		- Lumen (LvCo)  
	+ Front-end:  
		- Vite / mix  
		- template front end wajed  

--> Roles: (each role has folder)  
1- Admin  
2- User  

--> User stories:  

1- Authentication:  
	+ En tant qu'utilisateur, je peux créer un compte en utilisant mon adresse e-mail et un mot de passe sécurisé.  
	+ En tant qu'utilisateur, je peux me connecter à mon compte existant en utilisant mon adresse e-mail et mon mot de passe.  
	+ En tant qu'utilisateur, je peux réinitialiser mon mot de passe en utilisant mon adresse e-mail associée à mon compte.  

2- CRUDs:  

I- User:  
	+ Profile:  
		- En tant qu'utilisateur, je peux modifier les informations de mon compte, telles que mon adresse e-mail et mon mot de passe, en tout temps.  
		- En tant qu'utilisateur, je peux supprimer mon compte, en validant la suppression par entrer mon mot de passe.  
	
	+ Articles:  
		- En tant qu'utilisateur, je peux créer un nouvel article en saisissant   
			un titre,   
			une description,   
			un contenu   
			et en associant des catégories   
			et des tags.  

		- En tant qu'utilisateur, je peux éditer ou supprimer mes articles existants.  

		- En tant qu'utilisateur, je peux consulter la liste des articles disponibles,   
			- filtrer par catégorie et/ou par tag,   
			- afficher les détails d'un article en particulier.  
	+ Comments:
		- En tant qu'utilisateur, je peux créer un nouveau commentaire pour un article en particulier.  

		==> Reply to comments  

II-Admin:  
	+ Articles / Categories / Tags / Comments  
		- En tant qu'administrateur, je peux éditer ou supprimer tous  
			les articles  
			les commentaires  
			les tags (tableau separee many to many relationship) -> tags existant appeared to user   
			
			-> et Ajouter:  
			
			les catégories  

===> a table between stored the articles with their tags, comments and categories 	  
		
		- En tant qu'administrateur, je peux créer, éditer et supprimer   
			- des catégories   
			- des tags.  
	+ Roles:  
		- En tant que Super administrateur, je peux créer, éditer et supprimer des rôles utilisateur, et affecter des permissions d'accès à chaque rôle  
		-->> first phase: super admin can give anyone in the website the permission to be admin or User.  
		-->> second phase: super admin can give each one a permession or remove it (add article / modify article ...)  
		-->> third phase: crud roles  
