import tensorflow as tf
from tensorflow.keras.callbacks import EarlyStopping
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import LSTM, Dropout, Dense
from tensorflow.keras.optimizers import Adam
import joblib
import pandas as pd
import numpy as np
import pickle
import sys

print("hello")
# argument = sys.argv
# numbers_string = argument[1]
#
# # Removing the brackets and splitting the string by comma to get individual numbers as strings
# numbers_list = numbers_string.strip('[]').split(',')
#
# # Converting the strings to floats
# numbers = [float(num) for num in numbers_list]
#
# model = tf.keras.models.load_model('/var/www/Major_backend/app/Http/Controllers/model')
# with open('/var/www/Major_backend/app/Http/Controllers/saved_dictionary.pkl', 'rb') as f:
#     min_max_values = pickle.load(f)
# # label_encoder = joblib.load('/var/www/Major_backend/app/Http/Controllers/label_encoder_dict.joblib')
# data = {
#     'BMI': [numbers[0]],       # Example BMI value
#     'Systolic_Pressure': [numbers[1]],   # Example Systolic value
#     'Sugar_Level': [numbers[2]]  # Example Sugar_Level value
# }
# data = {
#     'BMI': [32],       # Example BMI value
#     'Systolic_Pressure': [120],   # Example Systolic value
#     'Sugar_Level': [110]  # Example Sugar_Level value
# }
# # Create DataFrame from the dictionary
# demo_df = pd.DataFrame(data)
#
# scaled_demo_df = demo_df.copy()
#
# columns_to_scale=['BMI','Systolic_Pressure','Sugar_Level']
# for column in columns_to_scale:
#     if column in min_max_values:
#         min_val = min_max_values[column]['min']
#         max_val = min_max_values[column]['max']
#         scaled_demo_df[column] = ((demo_df[column] - min_val) / (max_val - min_val))
# scaled_demo_df=scaled_demo_df.iloc[0]
# scaled_demo_df=scaled_demo_df.to_numpy()
# scaled_demo_df = scaled_demo_df.reshape((1, 1, 3))
# inp=scaled_demo_df
# ans=(model.predict(inp))
# data_array = np.array(ans)
# ans = pd.DataFrame(data_array, columns=['Duration','Duration_2','Duration_3','Exercise_Name','Exercise_Name_2','Exercise_Name_3'])
# data = {
#     'BMI':[scaled_demo_df[0][0][0]],
#     'Systolic_Pressure':[scaled_demo_df[0][0][1]],
#     'Sugar_Level':[scaled_demo_df[0][0][2]]
#
# }
# inp = pd.DataFrame(data)
# out=pd.concat([inp,ans], axis=1)
# unscaled_df = out.copy()
# columns_to_scale=['BMI','Systolic_Pressure','Sugar_Level','Duration','Duration_2','Duration_3','Exercise_Name','Exercise_Name_2','Exercise_Name_3']
# for column in columns_to_scale:
#     if column in min_max_values:
#         min_val = min_max_values[column]['min']
#         max_val = min_max_values[column]['max']
#         unscaled_df[column] = (out[column] * (max_val - min_val)) + min_val
# decoded_df = unscaled_df.copy()
# columns_to_decode = ['Exercise_Name','Exercise_Name_2','Exercise_Name_3']
#
# for column in columns_to_decode:
#     # Ensure the data is in the correct form for decoding
#     decoded_df[column] = np.rint(decoded_df[column]).astype(int)
#
#     # Retrieve the respective LabelEncoder for the column
#     lolo= joblib.load('/var/www/Major_backend/app/Http/Controllers/label_encoder_dict.joblib')
#     le = lolo.get(column)
#
#     # Check if the LabelEncoder exists
#     if le is not None:
#         # Decode the column
#         try:
#           decoded_df[column] = le.inverse_transform(decoded_df[column])
#         except ValueError as e:
#             print(f"Error decoding {column}: {e}")
#     else:
#         print(f"No encoder found for {column}")
# print(decoded_df.to_numpy())
