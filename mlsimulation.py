# Copyright by Samuel M. Koesnadi 2016 from Universität Duisburg Essen

import numpy as np
from sklearn import tree
import random

class UDE_data() :
# declare feature_names
    def __init__(self):
        self.feature_names = ['photography', 'speech', 'music', 'game', 'sport',
                            'mathematics', 'art and cultures']
        self.target_names = ['Visual', 'Verbal', 'Auditory', 'Kinetics']
        self.features = []
        self.targets = []
        self.sample = 500
        self.uncertainty = 10

    def generateVisual(self, visualData):
        for a in range(self.sample):
            featureVisual = []
            for data in visualData:
                featureVisual.append(data+(self.uncertainty*random.uniform(-1,1)))
            (self.features).append(featureVisual)
            (self.targets).append(0)

    def generateVerbal(self, visualData):
        for a in range(self.sample):
            featureVisual = []
            for data in visualData:
                featureVisual.append(data+(self.uncertainty*random.uniform(-1,1)))
            (self.features).append(featureVisual)
            (self.targets).append(1)

    def generateAuditory(self, visualData):
        for a in range(self.sample):
            featureVisual = []
            for data in visualData:
                featureVisual.append(data+(self.uncertainty*random.uniform(-1,1)))
            (self.features).append(featureVisual)
            (self.targets).append(2)

    def generateKinetics(self, visualData):
        for a in range(self.sample):
            featureVisual = []
            for data in visualData:
                featureVisual.append(data+(self.uncertainty*random.uniform(-1,1)))
            (self.features).append(featureVisual)
            (self.targets).append(3)


#data
visualDatas = [90,60,30,20,55,30,30]
verbalDatas = [25,95,35,20,10,50,55]
auditoryDatas = [10,50,90,20,30,10,15]
KineticsDatas = [10,30,25,95,90,10,30]

#main
ude = UDE_data()
ude.generateVisual(visualDatas)
ude.generateVerbal(verbalDatas)
ude.generateAuditory(auditoryDatas)
ude.generateKinetics(KineticsDatas)
#-----#

#train the data
from sklearn.neighbors import KNeighborsClassifier
from sklearn import tree
my_classifier = tree.DecisionTreeClassifier()
my_classifier.fit(ude.features, ude.targets)

#what do you want to predict?
p_sample = []

print ("Please input the content values as the reference to predict the learning type")
for a in range(len(ude.feature_names)):
    p_sample.append(int(input(" - %s values = " % ((ude.feature_names)[a]))))

predictions = my_classifier.predict(p_sample)
nameofprediction = ude.target_names[predictions]
#---

#OUTPUT
for a in range(100):
    print()
print ("The style of this individual is {}".format(repr(nameofprediction)))
input()
#---

# viz code
from sklearn.externals.six import StringIO
import pydotplus
dot_data = StringIO()
tree.export_graphviz(my_classifier, out_file=dot_data, feature_names=ude.feature_names, class_names=ude.target_names, filled=True, rounded=True, impurity=False)

graph = pydotplus.graph_from_dot_data(dot_data.getvalue())
graph.write_pdf("smartcontent.pdf")
