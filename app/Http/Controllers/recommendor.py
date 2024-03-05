from sklearn.cluster import KMeans
from sklearn.preprocessing import StandardScaler
from sklearn.pipeline import Pipeline
from sklearn.metrics.pairwise import euclidean_distances
from collections import defaultdict
import pandas as pd
import numpy as np
import sys
import json
import re
from scipy import stats


argument = sys.argv
# print(argument[1])
# Regular expression pattern to match key-value pairs
pattern = r'(\w+):([\d.]+)'
# Extracting key-value pairs using regular expression
matches = re.findall(pattern, argument[1])

# Creating variables dynamically for each value
data_dict = {key: float(value) for key, value in matches}

if 'sodium' in data_dict and 'sugar' in data_dict:
# Now you can access each value using its corresponding key
    calories = data_dict.get('calories', 0.0)  # Default value 0.0 if 'calories' key is not found
    total_fat = data_dict.get('total_fat', 0.0)
    protein = data_dict.get('protein', 0.0)
    carbs = data_dict.get('carbs', 0.0)
    sodium = data_dict.get('sodium', 0.0)
    sugar = data_dict.get('sugar', 0.0)

    flist={'calories': calories,'sugar':0,'carbs':carbs,'sodium':0}

elif 'sodium' in data_dict and 'sugar' not in data_dict:
    calories, protein, total_fat, carbs, sodium = map(float, [value for key, value in matches])

    flist={'calories': calories, 'sodium':0}

elif 'sodium' not in data_dict and 'sugar' in data_dict:
    calories, protein, total_fat, carbs, sugar = map(float, [value for key, value in matches])

    flist={'calories': calories,'total_fat':total_fat,'sugar':0,'carbs':carbs}

elif 'sodium' not in data_dict and 'sugar' not in data_dict:
    calories, total_fat, protein, carbs = map(float, [value for key, value in matches])

    flist={'calories': calories,'protein':protein,'total_fat':total_fat,'carbs':carbs}


def recommendation(flist):
    df1=pd.read_csv("/var/www/Major_backend/app/Http/Controllers/df1.csv")
    df1.drop('Unnamed: 0', axis=1, inplace=True)
    kmeans =Food_Recommender([flist],df1)
    return kmeans
def Food_Recommender(food_list, df):
    tmp = []
    for x in food_list:
        if 'calories' in x:
            calories = x['calories']
            tmp.append(calories)
        if 'protein' in x:
            protein = x['protein']
            tmp.append(protein)
        if 'sugar' in x:
            sugar = x['sugar']
            tmp.append(sugar)
        if 'sodium' in x:
            sodium = x['sodium']
            tmp.append(sodium)
        if 'total_fat' in x:
            total_fat = x['total_fat']
            tmp.append(total_fat)
        if 'carbs' in x:
            carbs = x['carbs']
            tmp.append(carbs)

    df = df[food_list[0].keys()]
    df.loc[1] = tmp
    df1=df[(np.abs(stats.zscore(df)) < 3).all(axis=1)]

    scaler = StandardScaler()

    scaled_X = scaler.fit_transform(df1.values)

    scaled_df = pd.DataFrame(scaled_X,columns=df1.columns)

#     kmeans = KMeans(n_clusters=6,init='k-means++',n_init=100,random_state=5).fit(scaled_df)
    reference_point = df.loc[1]

    distances = np.sqrt(np.sum((df - reference_point)**2, axis=1))

    closest_indices = np.argsort(distances)[1:5+1]

    closest_points = df.loc[closest_indices]
    index= closest_points.index
    pdf=pd.read_csv("/var/www/Major_backend/app/Http/Controllers/merged.csv")
    foods=pdf.iloc[index]
    return(foods[['name','nutrition']].to_dict('records'))

print(recommendation(flist))

#
# from sklearn.cluster import KMeans
# from sklearn.preprocessing import StandardScaler
# from sklearn.pipeline import Pipeline
# from sklearn.metrics.pairwise import euclidean_distances
# from collections import defaultdict
# import pandas as pd
# import numpy as np
# import sys
# import json
# import re
# from scipy import stats
#
# # argument = sys.argv
# # print(argument[1])
# # Regular expression pattern to match key-value pairs
# pattern = r'(\w+):([\d.]+)'
#
# # Extracting key-value pairs using regular expression
# # matches = re.findall(pattern, argument[1])
#
# # Creating variables dynamically for each value
# data_dict = {'calories': 898.47, 'protein': 24.0, 'total_fat': 24.96, 'sugar': 0, 'carbs': 123.54, 'sodium': 0}
#
#
# if 'sodium' in data_dict and 'sugar' in data_dict:
# # Now you can access each value using its corresponding key
#     calories = data_dict.get('calories', 0.0)  # Default value 0.0 if 'calories' key is not found
#     total_fat = data_dict.get('total_fat', 0.0)
#     protein = data_dict.get('protein', 0.0)
#     carbs = data_dict.get('carbs', 0.0)
#     sodium = data_dict.get('sodium', 0.0)
#     sugar = data_dict.get('sugar', 0.0)
#
#     flist={'calories': calories,'protein':protein,'total_fat':total_fat,'sugar':sugar,'carbs':carbs,'sodium':sodium}
#
# elif 'sodium' in data_dict and 'sugar' not in data_dict:
#     calories, total_fat, protein, carbs, sodium = map(float, [value for key, value in matches])
#
#     flist={'calories': calories,'protein':protein,'total_fat':total_fat,'carbs':carbs,'sodium':sodium}
#
# elif 'sodium' not in data_dict and 'sugar' in data_dict:
#     calories, total_fat, protein, carbs, sugar = map(float, [value for key, value in matches])
#
#     flist={'calories': calories,'protein':protein,'total_fat':total_fat,'sugar':sugar,'carbs':carbs}
#
# elif 'sodium' not in data_dict and 'sugar' not in data_dict:
#     calories, total_fat, protein, carbs = map(float, [value for key, value in matches])
#
#     flist={'calories': calories,'protein':protein,'total_fat':total_fat,'carbs':carbs}
#
#
# def recommendation(flist):
#     df1=pd.read_csv("/var/www/Major_backend/app/Http/Controllers/df1.csv")
#     df1.drop('Unnamed: 0', axis=1, inplace=True)
#     kmeans =Food_Recommender([flist],df1)
#     return kmeans
#
# def Food_Recommender(food_list, df):
#     tmp = []
#     for x in food_list:
#         if 'calories' in x:
#             calories = x['calories']
#             tmp.append(calories)
#         if 'protein' in x:
#             protein = x['protein']
#             tmp.append(protein)
#         if 'sugar' in x:
#             sugar = x['sugar']
#             tmp.append(sugar)
#         if 'sodium' in x:
#             sodium = x['sodium']
#             tmp.append(sodium)
#         if 'total_fat' in x:
#             total_fat = x['total_fat']
#             tmp.append(total_fat)
#         if 'carbs' in x:
#             carbs = x['carbs']
#             tmp.append(carbs)
#
#     df = df[food_list[0].keys()]
#     df.loc[1] = tmp
#     df1=df[(np.abs(stats.zscore(df)) < 3).all(axis=1)]
#
#     scaler = StandardScaler()
#
#     scaled_X = scaler.fit_transform(df1.values)
#
#     scaled_df = pd.DataFrame(scaled_X,columns=df1.columns)
#
#     kmeans = KMeans(n_clusters=6,init='k-means++',n_init=100,random_state=5).fit(scaled_df)
#     reference_point = df.loc[1]
#
#     distances = np.sqrt(np.sum((df - reference_point)**2, axis=1))
#
#     closest_indices = np.argsort(distances)[1:5+1]
#
#     closest_points = df.loc[closest_indices]
#
#     return closest_points
#
# print(recommendation(flist))
