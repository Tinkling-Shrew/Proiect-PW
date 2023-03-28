from StepsTracker import StepsTracker
from collections import OrderedDict


def dfs_algorithm(start, goal, search_space):
    tree_state = [{'node': start, 'parent': None}]
    queue = OrderedDict()
    queue[start] = {'parent': None}
    tracker = StepsTracker("Depth First Search", "Stack")

    tracker.add_step(
        tree_state, queue, f"We begin by placing the starting node ({start}) in the stack and in the tree.")

    while queue:
        current_node = list(queue.keys())[0]
        parent = queue[current_node]["parent"]
        queue.pop(current_node)
        tracker.add_step(
            tree_state, queue, f"We take the next node in the stack ({current_node}), mark it as the new current node and remove it from the stack.", [current_node])

        if current_node == goal:
            tracker.add_step(
                tree_state, queue, f"We found the goal node ({current_node})!", [current_node])
            break

        children = []
        for child in dict(search_space[current_node]).keys():
            if child != parent:
                children.append(child)
                queue[child] = {'parent': current_node}
                tree_state.append({'node': child, 'parent': current_node})
        for child in reversed(children):
            queue.move_to_end(child, last=False)
        tracker.add_step(
            tree_state, queue, "Since the current node is not the goal node, we expand it and add its children to the stack.", children)
    else:
        tracker.add_step(
            tree_state, queue, f"The goal node ({goal}) was not found in the search space.")

    return tracker
