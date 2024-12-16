INSERT INTO public.departement (id, nom, description)
VALUES ('D001', 'Ressources Humaines', 'Gestion du personnel et des relations de travail.'),
       ('D002', 'Informatique', 'Support technique et développement des systèmes d''information.'),
       ('D003', 'Marketing', 'Promotion des produits et gestion des campagnes publicitaires.'),
       ('D004', 'Finances', 'Gestion des budgets, comptabilité et audits financiers.'),
       ('D005', 'Ventes', 'Gestion des ventes et relations avec les clients.'),
       ('D006', 'Recherche et Développement', 'Innovation et développement de nouveaux produits.'),
       ('D007', 'Production', 'Gestion des processus de production et contrôle de la qualité.'),
       ('D008', 'Service Client', 'Support et assistance pour les clients.'),
       ('D009', 'Logistique', 'Gestion des stocks et coordination des livraisons.'),
       ('D010', 'Administration', 'Support administratif et gestion des installations.');

INSERT INTO public.poste (id, nom, description, responsabilites, exigences)
VALUES ('P001', 'Directeur des Ressources Humaines', 'Responsable de la gestion du personnel.',
        'Superviser le recrutement, gerer les conflits, developper des politiques RH.',
        'Diplome en gestion des ressources humaines, 10 ans d''experience.'),
       ('P002', 'Developpeur Logiciel', 'Developpe et maintient des applications logicielles.', 'Ecrire du code,
        tester les applications, collaborer avec les equipes.', 'Diplome en informatique,
        3 ans d''experience en developpement logiciel.'),
       ('P003', 'Responsable Marketing',
        'Dirige les strategies de marketing de l''entreprise.', 'Planifier des campagnes, analyser les donnees,
        gerer l''equipe marketing.', 'Diplome en marketing, 5 ans d''experience.'),
       ('P004', 'Comptable', 'Gere les comptes financiers de l''entreprise.',
        'Tenir les livres de comptes, preparer les declarations fiscales, auditer les finances.',
        'Diplome en comptabilite, 4 ans d''experience.'),
       ('P005', 'Responsable des Ventes', 'Supervise l''equipe de vente et les strategies de vente.',
        'Developper des strategies de vente, former l''equipe de vente,
        atteindre les objectifs de vente.', 'Diplome en commerce, 6 ans d''experience en vente.'),
       ('P006', 'Ingenieur R&D', 'Travaille sur le developpement de nouveaux produits.',
        'Concevoir et tester des prototypes, collaborer avec les equipes de production, documenter les resultats.',
        'Diplome en ingenierie, 3 ans d''experience en R&D.'),
       ('P007', 'Chef de Production', 'Supervise les operations de production.', 'Planifier la production, assurer la qualite,
        gerer l''equipe de production.', 'Diplome en gestion de production, 5 ans d''experience.'),
       ('P008', 'Representant du Service Client', 'Fournit un support et une assistance aux clients.', 'Repondre aux demandes des clients,
        resoudre les problemes, fournir des informations sur les produits.', 'Diplome en communication,
        2 ans d''experience en service client.'),
       ('P009', 'Coordinateur Logistique',
        'Gere la chaine d''approvisionnement et les livraisons.', 'Planifier les livraisons, gerer les stocks,
        coordonner avec les fournisseurs.', 'Diplome en logistique, 4 ans d''experience.'),
       ('P010', 'Assistant Administratif', 'Fournit un support administratif.',
        'Gerer les documents, organiser les reunions, soutenir les operations quotidiennes.',
        'Diplome en administration, 2 ans d''experience en support administratif.');

INSERT INTO public.type_contrat (id, designation, duree_minimum, duree_maximum)
VALUES ('TC001', 'CDI', NULL, NULL),
       ('TC002', 'CDD', 1, 36),
       ('TC003', 'Essai', 1, 6);

INSERT INTO public.etape_recrutement (id, nom, description, niveau)
VALUES ('ER001', 'En attente', 'Candidature en attente de traitement.', 1),
       ('ER002', 'Contacté', 'Candidat contacté pour un premier échange.', 2),
       ('ER003', 'En phase de test', 'Candidat en phase de test ou évaluation technique.', 3),
       ('ER004', 'À interviewer', 'Candidat à interviewer pour évaluation plus poussée.', 4),
       ('ER005', 'Accepté', 'Candidat accepté pour le poste.', 5),
       ('ER006', 'Refusé', 'Candidature refusée.', 6);


INSERT INTO type_conge (id,designation)
VALUES
    ('TCG001','Congés Payés'),
    ('TCG002','Congés Sans Solde'),
    ('TCG003','Congés Spéciaux ou Exceptionnels'),
    ('TCG004','Congés Maladie'),
    ('TCG005','Congé de Maternité, Paternité et Adoption'),
    ('TCG006','Congés Sabbatiques'),
    ('TCG007','Congés Formation');


INSERT INTO demande_conge (id_utilisateur, id_type_conge, date_debut, date_fin, description, status)
VALUES
( 'user001', 'TCG001', '2024-12-01', '2024-12-10', 'Vacances de fin d année', 'En attente'),

('user002', 'TCG004', '2024-11-20', '2024-11-25', 'Repos médical après intervention', 'Approuve'),

( 'user001', 'TCG007', '2024-11-15', '2024-11-20', 'Participation à un séminaire professionnel', 'Refuse'),

('user002', 'TCG002', '2024-12-15', '2024-12-20', 'Voyage personnel important', 'En attente'),

( 'user002', 'TCG005', '2025-01-01', '2025-04-01', 'Congé maternité pour la naissance de mon enfant', 'En attente');
