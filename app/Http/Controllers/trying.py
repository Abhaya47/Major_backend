import os
import pprint
import tempfile

from typing import Dict, Text
import pandas as pd
import numpy as np
import tensorflow as tf
import tensorflow_recommenders as tfrs
import sys
import warnings
import os
import tensorflow as tf

os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3'
argument = sys.argv
# warnings.filterwarnings("ignore")

  # Load it back; can also be done in TensorFlow Serving.

loaded = tf.saved_model.load("/var/www/Major_backend/app/Http/Controllers/saved_model")


       #pass body part get exercise
scores, titles = loaded([argument[1]])
print(f"{titles[0][:5]}")

