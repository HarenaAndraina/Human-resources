-- Insérer des données dans la table departement
INSERT INTO departement (id, nom, description) VALUES
('dep001', 'Informatique', 'Département responsable des technologies information'),
('dep002', 'Ressources Humaines', 'Département responsable de la gestion des employés');

-- Insérer des données dans la table poste
INSERT INTO poste (id, nom, description, responsabilites, exigences) VALUES
('pos001', 'Développeur', 'Développeur logiciel', 'Développer des applications', 'Connaissance de plusieurs langages de programmation'),
('pos002', 'Responsable RH', 'Gestion du personnel', 'Gestion des recrutements', 'Excellente connaissance des ressources humaines');

INSERT INTO type_contrat (id, designation, duree_minimum, duree_maximum) VALUES
('cd1', 'CDI', 12, 36),
('cd2', 'CDD', 6, 24);

-- Insérer des données dans la table contrat
INSERT INTO contrat (id, type_id, date_debut, duree) VALUES
('contrat001', 'cd1', '2023-01-01', 24),
('contrat002', 'cd2', '2023-06-01', 12);

-- Insérer des données dans la table utilisateur
INSERT INTO utilisateur (id, id_departement, id_poste, id_contrat, nom, prenom, email, telephone, date_naissance, salaire, roles, password,debut_activite) VALUES
('user001', 'dep001', 'pos001', 'contrat001', 'Dupont', 'Jean', 'jean.dupont@example.com', '0601020304', '1990-05-14', 3500.00, '["ROLE_USER"]', 'password123','02-04-2010'),
('user002', 'dep002', 'pos002', 'contrat002', 'Martin', 'Anne', 'anne.martin@example.com', '0605060708', '1985-10-30', 4200.00, '["ROLE_ADMIN"]', 'securepassword','08-02-2012');

-- Insérer des évaluations
INSERT INTO evaluation (id, date_evaluation, juge_id, utilisateur_id, score_moyenne) VALUES
('eval001', '2024-11-11', 'user001', 'user002', 4),
('eval002', '2024-11-10', 'user002', 'user001', 4.28);

-- Insérer des détails d'évaluation
INSERT INTO detail_evaluation (evaluation_id, comportement, attitude, competence, connaissance, administrative) VALUES
('eval001', 4.00, 3.80, 4.20, 3.90, 4.10),
('eval002', 4.30, 4.00, 4.50, 4.20, 4.40);

-- Insérer des retours sur l'évaluation
INSERT INTO feedback (evaluation_id, positif_avis, critique_avis) VALUES
('eval001', 'Bon travail, continuez ainsi.', 'Peut améliorer la gestion du temps.'),
('eval002', 'Excellentes performances, très fiable.', 'Attention à la gestion des priorités.');


SELECT 
    u.id, 
    u.nom, 
    u.prenom,
    u.email,
    u.debut_activite 
    AVG(de.connaissance) AS avg_connaissance
FROM 
    utilisateur u
LEFT JOIN 
    evaluation e ON u.id = e.utilisateur_id  -- Jointure avec evaluation
LEFT JOIN 
    detail_evaluation de ON e.id = de.evaluation_id  -- Jointure avec detail_evaluation
GROUP BY 
    u.id  -- Grouper par utilisateur
ORDER BY 
    avg_connaissance ASC;  -- Trier par la moyenne des connaissances (du plus grand au plus petit)

SELECT 
    u.id, 
    u.nom, 
    u.prenom, 
    u.debut_activite
FROM 
    utilisateur u
ORDER BY 
    u.debut_activite DESC;  -- Trier par la date de début d'activité (du plus récent au plus ancien)

SELECT 
    u.id, 
    u.nom, 
    u.prenom,
    u.email, 
    AVG(e.score_moyenne) AS avg_note
FROM 
    utilisateur u
LEFT JOIN 
    evaluation e ON u.id = e.utilisateur_id 
WHERE 
    e.date_evaluation <= '16-11-2024'  
GROUP BY 
    u.id  
ORDER BY 
    avg_note DESC;  
