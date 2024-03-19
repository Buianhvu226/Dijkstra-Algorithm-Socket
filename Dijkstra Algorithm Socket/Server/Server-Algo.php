<?php

// Function to perform Dijkstra's algorithm
function dijkstra($graph, $startVertex)
{
    $verticesCount = count($graph)-1;
    $distances = [];
    $visited = [];
    $previous = [];

    for ($i = 0; $i < $verticesCount; $i++) {
        $distances[$i] = INF;
        $visited[$i] = false;
        $previous[$i] = -1;
    }

    $distances[$startVertex] = 0;

    for ($i = 0; $i < $verticesCount; $i++) {
        $minDistance = INF;
        $minIndex = -1;

        for ($j = 0; $j < $verticesCount; $j++) {
            if (!$visited[$j] && $distances[$j] < $minDistance) {
                $minDistance = $distances[$j];
                $minIndex = $j;
            }
        }

        $visited[$minIndex] = true;

        for ($j = 0; $j < $verticesCount; $j++) {
            if ($graph[$minIndex][$j] && !$visited[$j]) {
                $newDistance = $distances[$minIndex] + $graph[$minIndex][$j];
                if ($newDistance < $distances[$j]) {
                    $distances[$j] = $newDistance;
                    $previous[$j] = $minIndex;
                }
            }
        }
    }

    // Return distances and previous vertices for path reconstruction
    return [$distances, $previous];
}

function getPath($beginVertex, $currentVertex, $previousVertices)
{
    $path = [];
    while ($currentVertex !== $beginVertex) {
        $path[] = $currentVertex;
        $currentVertex = $previousVertices[$currentVertex];
    }
    $path[] = $beginVertex;
    return array_reverse($path);
}

?>