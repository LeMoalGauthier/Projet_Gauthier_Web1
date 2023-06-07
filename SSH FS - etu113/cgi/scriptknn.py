def knn_predict_accident(accident_info, accidents_file):
    # Charger le fichier CSV des accidents dans une DataFrame
    accidents_data = pd.read_csv(accidents_file, delimiter=";")

    #modification en 2 classes de la gravité
    accidents_data['descr_grav'] = accidents_data['descr_grav'].replace({
        'Indemne': 'pas grave',
        'Blessé léger': 'pas grave',
        'Blessé hospitalisé': 'grave',
        'Tué': 'grave'
    })

    #convertion en float des latitudes et des longitudes
    accidents_data["latitude"] = accidents_data["latitude"].str.replace(',', '.')
    accidents_data["latitude"] = accidents_data["latitude"].astype(float)
    accidents_data["longitude"] = accidents_data["longitude"].str.replace(',', '.')
    accidents_data["longitude"] = accidents_data["longitude"].astype(float)
  
    # Création de l'objet LabelEncoder
    le = LabelEncoder()
    for var in columns_to_convert:
        accidents_data[var] = le.fit_transform(accidents_data[var])

    # Séparer les features (X) et les labels (y) à partir du jeu de données après le label encoding
    X = accidents_data.drop('descr_grav', axis=1)
    y = accidents_data['descr_grav']

    # Créer un modèle KNN avec k=5
    knn = KNeighborsClassifier(n_neighbors=5)

    # Ajuster le modèle aux données d'entraînement
    knn.fit(X, y)

    # Réorganiser les colonnes dans le jeu de données de test
    accident_info_reordered = pd.DataFrame.from_dict([accident_info], orient='columns')
    accident_info_reordered = accident_info_reordered[X.columns]

    # Prédire la classe de l'accident donné
    predicted_class = knn.predict(accident_info_reordered)

    # Convertir la prédiction en "grave" ou "pas grave"
    predicted_class_string = "grave" if predicted_class[0] == 0 else "pas grave"

    # Retourner la classe de l'accident sous forme de JSON
    result = {'descr_grav': predicted_class_string}
    json_result = json.dumps(result)
    #print(le.inverse_fit())

    return json_result

# Exemple d'utilisation du script
#les '#' montre un exemple d'accident grave
accident_info = {
    'descr_cat_veh': 21,#21
    'descr_agglo': 1,#1
    'descr_lum': 4,#4
    'descr_athmo': 0,#0
    'descr_etat_surf': 8,#8
    'descr_type_col': 0,#0
    'latitude': 47.1167,#47.1
    'longitude': -2.1000,#-2.1
    'descr_dispo_secu':7#7
}  
#appel de la fonction
predicted_class_json = knn_predict_accident(accident_info, accidents_file)
#affiche le resultat
print(predicted_class_json)

_______________________________________________________________________________________________________________
#!/usr/bin/python3.9

# exemple d'appel du script en ligne de commande ou exec php : python /var/www/etu000/cgi/test.py request=bonjour
# exemple d'appel du script depuis le navigateur http://etu000.projets.isen-ouest.fr/cgi/test.py?request=bonjour

# ecrit le header requis pour un affichage dans le navigateur (ne pas oublier le retour à la ligne obligatoire en fin de print)

print ("Content-type: application/json \r\n")

# https://docs.python.org/3.9/library/cgi.html
import cgi
import cgitb
import numpy as np
from sklearn.neighbors import KNeighborsClassifier
from sklearn.preprocessing import LabelEncoder

# https://www.w3schools.com/python/python_json.asp
import json

# activation debeug CGI
cgitb.enable()

# recurperation des parametres de l'url envoyés par le formulaire dans la variable form
form = cgi.FieldStorage()
#print(form,"\n")
descr_grav = ['Indemne', 'Blessé léger', 'Blessé hospitalisé','Tué']
grav_converti = descr_grav.replace({
        'Indemne': 'pas grave',
        'Blessé léger': 'pas grave',
        'Blessé hospitalisé': 'grave',
        'Tué': 'grave'
    })
latitude = float(form['latitude'].value)
accident_grav = np.array([[latitude, longitude]])
gravite = np.array([[latitude, longitude]])

# # Créer un array numpy à partir de la liste des centroïdes
gravite_array = np.array(descr_grav)

# # Créer un modèle K-means avec le nombre de clusters égal au nombre de centroïdes
knn = KNeighborsClassifier(n_neighbors=5)

# # Ajuster le modèle aux données des centroïdes
knn.fit(descr_grav)

# # Prédire le cluster d'appartenance de l'accident
predicted_gravite = KNeighborsClassifier.predict(accident_coordinates)

# # Retourner le cluster d'appartenance sous forme de JSON
result = {'gravite': str(predicted_gravite)}

# #print(result)
# # verification de présence d'une clé dans le tableau form
if 'descr_grav' not in form:
     print('Il manque la gravité !!')
# else:
#     print('oui')
#     # lecture de la valeur de l'attribut dans une variable



# # transformation de la variable dic en chaine de caractères JSON
dic_json = json.dumps(result)

# # affichage d'exemple d'une chaine json
# # print ('{"request": "'+request+'", "tab": ["v1","v2","v3"]}')
print(dic_json)