import pandas as pd
import mysql.connector

# Se connecter à la base de données MySQL
connexion = mysql.connector.connect(
    host='etu115.projets.isen-ouest.fr',
    user='etu115',
    password='fcsvberc',
    database='grande_table_accidents'
)

# Créer un curseur pour exécuter les requêtes SQL
curseur = connexion.cursor()

# Lire le fichier CSV dans un dataframe
dataframe = pd.read_csv('export_IA2.csv')

# Supprimer la première ligne (titres des colonnes)
dataframe = dataframe.iloc[1:]

# Parcourir les lignes du dataframe et insérer les données dans la table
for index, row in dataframe.iterrows():
    # Récupérer les valeurs de chaque colonne
    Num_Acc = int(row['Num_Acc'])
    num_veh = row['num_veh']
    id_usa = int(row['id_usa'])
    date = pd.to_datetime(row['date'])
    ville = row['ville']
    id_code_insee = row['id_code_insee']
    latitude = float(row['latitude'].replace(',', '.'))
    longitude = float(row['longitude'].replace(',', '.'))
    descr_cat_veh = row['descr_cat_veh']
    descr_agglo = row['descr_agglo']
    descr_athmo = row['descr_athmo']
    descr_lum = row['descr_lum']
    descr_etat_surf = row['descr_etat_surf']
    description_intersection = row['description_intersection']
    an_nais = int(row['an_nais'])
    age = int(row['age'])
    place = int(row['place'])
    descr_dispo_secu = row['descr_dispo_secu']
    descr_grav = row['descr_grav']
    descr_motif_traj = row['descr_motif_traj']
    descr_type_col = row['descr_type_col']

    sql = "INSERT INTO grande_table_accidents (Num_Acc, num_veh, id_usa, date, ville, id_code_insee, latitude, longitude, descr_cat_veh, descr_agglo, descr_athmo, descr_lum, descr_etat_surf, description_intersection, an_nais, age, place, descr_dispo_secu, descr_grav, descr_motif_traj, descr_type_col) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"

    # Données à insérer dans la table
    values = (Num_Acc, num_veh, id_usa, date, ville, id_code_insee, latitude, longitude, descr_cat_veh, descr_agglo, descr_athmo, descr_lum, descr_etat_surf, description_intersection, an_nais, age, place, descr_dispo_secu, descr_grav, descr_motif_traj, descr_type_col)

    # Exécuter la requête SQL avec les valeurs
    curseur.execute(sql, values)

    # Valider les modifications dans la base de données
    connexion.commit()