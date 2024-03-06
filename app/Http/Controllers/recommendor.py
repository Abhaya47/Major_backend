import sklearn
import joblib
import pickle
import tensorflow as tf
from tensorflow.keras.callbacks import EarlyStopping
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import LSTM, Dropout, Dense
from tensorflow.keras.optimizers import Adam
import pandas as pd
import numpy as np
import sys
import os
from typing import Dict, Text
import warnings
import os

argument = sys.argv
numbers_string = argument[1]

# Removing the brackets and splitting the string by comma to get individual numbers as strings
numbers_list = numbers_string.strip('[]').split(',')

# Converting the strings to floats
numbers = [float(num) for num in numbers_list]

model = tf.keras.models.load_model('/var/www/Major_backend/app/Http/Controllers/model')
with open('/var/www/Major_backend/app/Http/Controllers/saved_dictionary.pkl', 'rb') as f:
    min_max_values = pickle.load(f)
data = {
    'needs':[numbers[0]],
    'pressure':[numbers[1]],
    'sugarb':[numbers[2]]
}
# Create DataFrame from the dictionary
demo_df = pd.DataFrame(data)

scaled_demo_df = demo_df.copy()

columns_to_scale=['needs','pressure','sugarb']
for column in columns_to_scale:
    if column in min_max_values:
        min_val = min_max_values[column]['min']
        max_val = min_max_values[column]['max']
        scaled_demo_df[column] = ((demo_df[column] - min_val) / (max_val - min_val))
scaled_demo_df=scaled_demo_df.to_numpy()
scaled_demo_df = scaled_demo_df.reshape((1, 1, 3))
inp=scaled_demo_df
ans=model.predict(inp)

# Convert the array to a DataFrame
ans = pd.DataFrame(data_array, columns=['Calories','SodiumContent', 'CarbohydrateContent', 'SugarContent'])data = {
    'needs':[inp[0][0][0]],
    'pressure':[inp[0][0][1]],
    'sugarb':[inp[0][0][2]]
}

# Create DataFrame
inp = pd.DataFrame(data)

# Display the DataFrame
out=pd.concat([inp,ans], axis=1)
out
inp = pd.DataFrame(data)
out=pd.concat([inp,ans], axis=1)
unscaled_df = out.copy()

columns_to_scale=['Calories','SodiumContent','CarbohydrateContent', 'SugarContent','needs','pressure','sugarb']

for column in columns_to_scale:
    if column in min_max_values:
        min_val = min_max_values[column]['min']
        max_val = min_max_values[column]['max']
        # Apply the inverse min-max scaling formula
        unscaled_df[column] = (out[column] * (max_val - min_val)) + min_val

Calories=unscaled_df['Calories'][0]
SodiumContent=unscaled_df['SodiumContent'][0]
CarbohydrateContent=unscaled_df['CarbohydrateContent'][0]
SugarContent=unscaled_df['SugarContent'][0]

predicted_nutritional_data=pd.read_csv('/content/merged - Sheet1.csv')

# Define filtering criteria
desired_calorie_range = (Calories-100,Calories+100)  # Calorie range: 400-600 calories
desired_sodium_limit = (SodiumContent)# Sodium content limit: less than 1.5 grams
desired_carbohydrate_limit = (CarbohydrateContent)# Sodium content limit: less than 1.5 grams
desired_sugar_limit = (SugarContent)# Sodium content limit: less than 1.5 grams

# Ensure 'Sodium' is in grams. If it's in mg, you might need to convert:
# predicted_nutritional_data['Sodium'] = predicted_nutritional_data['Sodium'] / 1000

# Filter DataFrame based on criteria
filtered_df = predicted_nutritional_data[(predicted_nutritional_data['Calories'] >= desired_calorie_range[0]) &
                                         (predicted_nutritional_data['Calories'] <= desired_calorie_range[1]) &
                                         (predicted_nutritional_data['SodiumContent'] <= desired_sodium_limit)]

# Display filtered DataFrame
print(filtered_df)
print(decoded_df.to_numpy())

