import json
import os

from StepsTracker import StepsTracker
from collections import OrderedDict

base_path = os.path.dirname(__file__).__str__() + "\\"

f = open(base_path + "input.json", "r")

json_input = f.read()

f.close()

data = json.loads(json_input)

start = data["start"]
goal = data["goal"]
search_space = data["search_space"]

def bfs_algorithm(start, goal, search_space):
    tree_state = [{"node": start, "parent": None}]
    queue = OrderedDict()
    queue[start] = {"parent": None}
    tracker = StepsTracker("Breadth First Search", "Queue")

    tracker.add_step(
        tree_state, queue, f"We begin by placing the starting node ({start}) in the queue and in the tree.")

    while queue:
        current_node = list(queue.keys())[0]
        parent = queue[current_node]["parent"]
        queue.pop(current_node)
        tracker.add_step(
            tree_state, queue,
            f"We take the next node in the queue ({current_node}), mark it as the new current node and remove it from the queue.",
            [current_node])

        if current_node == goal:
            tracker.add_step(
                tree_state, queue, f"We found the goal node ({current_node})!", [current_node])
            break

        children = []
        for child in dict(search_space[current_node]).keys():
            if child != parent:
                children.append(child)
                queue[child] = {"parent": current_node}
                tree_state.append({"node": child, "parent": current_node})
        tracker.add_step(
            tree_state, queue,
            "Since the current node is not the goal node, we expand it and add its children to the queue.", children)
    else:
        tracker.add_step(
            tree_state, queue, f"The goal node ({goal}) was not found in the search space.")

    return tracker


f = open(base_path + "output.json", "w")

f.write(bfs_algorithm(start, goal, search_space).get_json())

f.close()



