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
heuristics = data["heuristics"]

def a_star_algorithm(start, goal, search_space, heuristics):
    available_paths = {}
    visited_nodes = {start: {'score': heuristics[start], 'parent': None}}
    current_node = start

    tracker = StepsTracker("A* Search", "Visited Nodes")
    temp_node = {"node": start}
    temp_node.update(visited_nodes[start])
    tree_state = [temp_node]
    tracker.add_step(tree_state, visited_nodes,
                     "We begin by marking the starting node as the current node, and visiting it.", [start])

    # loop until the currently explored node is the goal node
    while current_node != goal:
        print(f"{current_node}: {visited_nodes[current_node]['score']}")

        # expand the current node
        temp_list = []
        for node in search_space[current_node].keys():
            # add node to available paths along with its A* score (path length to get to that node + the node's heuristic) and parent
            available_paths[node] = {
                'score': visited_nodes[current_node]['score'] - heuristics[current_node] + search_space[current_node][
                    node] + heuristics[node],
                'parent': current_node
            }
            temp_node = {"node": node}
            temp_node.update(available_paths[node])
            tree_state.append(temp_node)
            temp_list.append(node)
        tracker.add_step(tree_state, visited_nodes,
                         f'Since the current node ({current_node}) is not the goal node ({goal}), we expand it.', temp_list)

        # checking which new path to take
        sorted_paths = sorted(available_paths.items(),
                              key=lambda x: x[1]['score'])
        for node, data in sorted_paths:
            # if the node hasn't been visited or it has but the new distance is less than the old one,
            # mark it as the current node and continue the main algorithm
            if node not in visited_nodes.keys() or data['score'] < visited_nodes[node]['score']:
                current_node = node
                tracker.add_step(
                    tree_state, visited_nodes, f'Out of the available paths, {current_node} has the lowest A* score ({data["score"]}), so we will mark it as the new current node.', [current_node])
                break
            # remove the node from available paths if its path is not satisfactory
            else:
                available_paths.pop(node)

        # mark node as visited
        visited_nodes[current_node] = available_paths[current_node]
        available_paths.pop(current_node)

    print(f"{current_node}: GOAL NODE!")
    tracker.add_step(tree_state, visited_nodes,
                     f'We found the goal node ({current_node})!', [current_node])

    # generate the final path by visiting the parent of each node starting from the goal,
    # until we reach a node with no parent, the starting node
    final_path = []
    while current_node != None:
        final_path.insert(0, current_node)
        current_node = visited_nodes[current_node]['parent']

    print(f"\nFinal path: {final_path}")
    tracker.add_step(tree_state, visited_nodes,
                     f'This is the final path.', final_path)
    return json.dumps(tracker)


f = open(base_path + "output.json", "w")

f.write(a_star_algorithm(start, goal, search_space, heuristics).get_json())

f.close()