import json
from copy import deepcopy

class StepsTracker:
    def __init__(self, alg_name, list_label):
        self.steps = []
        self.alg_name = alg_name
        self.list_label = list_label

    def add_step(self, tree_state, list, description="", highlighted_nodes=[]):
        self.steps.append({
            "tree": deepcopy(tree_state),
            "list": deepcopy(list),
            "highlights": deepcopy(highlighted_nodes),
            "description": description
        })

    def get_summary(self):
        return {
            "algorithm": self.alg_name,
            "list_label": self.list_label,
            "steps_count": len(self.steps),
            "steps": self.steps
        }

    def __str__(self):
        return str({
            "algorithm": self.alg_name,
            "list_label": self.list_label,
            "steps_count": len(self.steps),
            "steps": self.steps
        })

    def get_json(self):
        return json.dumps({
            "algorithm": self.alg_name,
            "list_label": self.list_label,
            "steps_count": len(self.steps),
            "steps": self.steps
        })
