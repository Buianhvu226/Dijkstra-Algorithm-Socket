const canvas = document.createElement('canvas');
const ctx = canvas.getContext('2d');
canvas.width = 1460;
canvas.height = 500;
const N =500;

let vertices = [];
let mt = [][N];
let edges = [];
let vertexCount = 0;
let isDragging = false;
let draggedVertex = null;
let selectedVertex = null;

////////////////////////////////////////////////////////////////////////////////////////////////////////////
function drawVertices() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    vertices.forEach(vertex => {
        ctx.beginPath();
        ctx.arc(vertex.x, vertex.y, 20, 0, Math.PI * 2);
        ctx.fillStyle = '#4CAF50';
        ctx.fill();
        ctx.stroke();
        ctx.fillStyle = 'black';
        ctx.fillText(vertex.label, vertex.x - 7.5, vertex.y + 8);
        ctx.font = '26px Arial';
    });

    edges.forEach(edge => {
        ctx.beginPath();
        ctx.moveTo(edge.start.x, edge.start.y);
        ctx.lineTo(edge.end.x, edge.end.y);
        ctx.strokeStyle = '#000';
        ctx.stroke();
    });
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
function handleVertexClick(event) {
    const rect = canvas.getBoundingClientRect();
    const x = event.clientX - rect.left;
    const y = event.clientY - rect.top;

    const clickedVertex = vertices.find(vertex => Math.sqrt((vertex.x - x) ** 2 + (vertex.y - y) ** 2) <= 20);

    if (!clickedVertex) {
        vertices.push({ x, y, label: vertexCount.toString() });
        vertexCount++;
        drawVertices();
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
function handleMouseDown(event) {
    const rect = canvas.getBoundingClientRect();
    const x = event.clientX - rect.left;
    const y = event.clientY - rect.top;

    const clickedVertex = vertices.find(vertex => Math.sqrt((vertex.x - x) ** 2 + (vertex.y - y) ** 2) <= 10);

    if (clickedVertex) {
        isDragging = true;
        draggedVertex = clickedVertex;
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
function handleMouseUp(event) {
    isDragging = false;
    draggedVertex = null;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
function handleMouseMove(event) {
    if (isDragging) {
        const rect = canvas.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;

        draggedVertex.x = x;
        draggedVertex.y = y;

        drawVertices();
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
function handleRightClick(event) {
    event.preventDefault();

    const rect = canvas.getBoundingClientRect();
    const x = event.clientX - rect.left;
    const y = event.clientY - rect.top;

    const clickedVertex = vertices.find(vertex => Math.sqrt((vertex.x - x) ** 2 + (vertex.y - y) ** 2) <= 20);

    if (clickedVertex) {
        if (selectedVertex === null) {
            selectedVertex = clickedVertex;
        } else if (selectedVertex === clickedVertex) {
            // Deselect the vertex if it's clicked twice
            selectedVertex = null;
        } else {
            const edgeExists = edges.some(edge =>
                (edge.start === selectedVertex && edge.end === clickedVertex) ||
                (edge.start === clickedVertex && edge.end === selectedVertex)
            );

            if (!edgeExists) {
                edges.push({ start: selectedVertex, end: clickedVertex });
                drawVertices();
                console.log(`Edge: ${selectedVertex.label} to ${clickedVertex.label}`);
            } else {
                console.log('An edge already exists between these vertices.');
            }

            selectedVertex = null;
        }
    } else {
        // Check if the click is on an edge and delete the closest one
        const closestEdgeIndex = findClosestEdgeIndex(x, y);
        if (closestEdgeIndex !== -1) {
            edges.splice(closestEdgeIndex, 1); // Remove the closest edge
            drawVertices();
            console.log('Edge deleted');
        }
    }
}



////////////////////////////////////////////////////////////////////////////////////////////////////////////
document.getElementById('deleteEdgeBtn').addEventListener('click', deleteEdgeByNamePrompt);

function deleteEdgeByNamePrompt() {
    const edgeNameToDelete = prompt('Nhập tên cạnh muốn xóa:');

    if (edgeNameToDelete !== null && edgeNameToDelete.trim() !== '') {
        const edgeIndex = edges.findIndex(edge => edge.name === edgeNameToDelete);

        if (edgeIndex !== -1) {
            edges.splice(edgeIndex, 1); // Remove the edge by name
            drawVertices();
            drawEdges();
            drawMatrix();
            drawEdgeTable();
            console.log(`Edge ${edgeNameToDelete} deleted`);
        } else {
            console.log(`Edge ${edgeNameToDelete} not found`);
        }
    } else {
        console.log('Please enter a valid edge name');
    }
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////
document.getElementById('deleteVertexBtn').addEventListener('click', deleteVertex);

function deleteVertex() {
    const vertexToDelete = window.prompt('Nhập đỉnh muốn xóa:');

    // Check if the input is a number and corresponds to an existing vertex
    if (vertexToDelete !== null && !isNaN(vertexToDelete)) {
        const vertexIndex = vertices.findIndex(vertex => vertex.label === vertexToDelete);

        if (vertexIndex !== -1) {
            // Remove edges connected to the vertex
            edges = edges.filter(edge => edge.start.label !== vertexToDelete && edge.end.label !== vertexToDelete);

            // Remove the vertex
            vertices.splice(vertexIndex, 1);

            // Redraw the vertices and edges
            drawVertices();
            drawEdgeTable();
            drawMatrix();
            console.log(`Vertex ${vertexToDelete} deleted`);
        } else {
            console.log(`Vertex ${vertexToDelete} not found`);
        }
    } else {
        console.log('Invalid input or operation canceled');
    }
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////
document.getElementById('newBtn').addEventListener('click', confirmResetGraph);

function confirmResetGraph() {
    const userConfirmed = window.confirm('Bạn có chắc muốn làm mới toàn bộ?');

    if (userConfirmed) {
        resetGraph();
    } else {
        console.log('Operation canceled');
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
function resetGraph() {
    vertices = [];
    edges = [];
    vertexCount = 0; // Reset the vertex count
    drawVertices();
    console.log('Graph reset');
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
document.getElementById('addEdgeBtn').addEventListener('click', addEdge);

function addEdge() {
    const firstPoint = document.getElementById('firstPoint').value.toLowerCase();
    const finalPoint = document.getElementById('finalPoint').value.toLowerCase();
    const weight = document.getElementById('weight').value;
    const nameVertex = document.getElementById('nameVertex').value;

    // Kiểm tra xem weight có phải là số nguyên dương không
    const isPositiveInteger = /^[0-9]\d*$/.test(weight);

    if (firstPoint && finalPoint && weight && isPositiveInteger) {

        if (firstPoint === finalPoint) {
            alert('Đỉnh đầu và đỉnh cuối không thể trùng nhau. Vui lòng chọn đỉnh khác!');
            return;
        }

        const startVertex = vertices.find(vertex => vertex.label.toLowerCase() === firstPoint);
        const endVertex = vertices.find(vertex => vertex.label.toLowerCase() === finalPoint);

        // Log start and end vertices to troubleshoot
        console.log('Start Vertex:', startVertex);
        console.log('End Vertex:', endVertex);

        // Check if both start and end vertices exist
        if (startVertex && endVertex) {
            // Check if there is already an edge with the same name
            const existingEdgeWithName = edges.find(edge =>
                (edge.name === nameVertex)
                
            );

            if (existingEdgeWithName) {
                console.log(`Edge with the same name already exists: ${startVertex.label} to ${endVertex.label}`);
                // Handle the error as needed, such as showing an alert or logging a message
                alert('Cạnh hoặc tên đã tồn tại. Xin hãy chọn một tên khác!');
            } else {
                // Check if there is already an edge between the start and end vertices
                const existingEdge = edges.find(edge =>
                    (edge.start === startVertex && edge.end === endVertex) ||
                    (edge.start === endVertex && edge.end === startVertex)
                );

                if (existingEdge) {
                    // Update weight and name if they are not empty
                    if (weight !== '') {
                        existingEdge.weight = weight;
                    }
                    if (nameVertex !== '') {
                        existingEdge.name = nameVertex;
                    }

                    console.log(`Edge updated: ${startVertex.label} to ${endVertex.label}`);
                } else {
                    // Create a new edge
                    edges.push({ start: startVertex, end: endVertex, weight: weight, name: nameVertex });
                    console.log(`New edge created: ${startVertex.label} to ${endVertex.label}`);
                   
                }

                // Redraw the vertices and edges
                drawVertices();
                drawEdges();
                drawMatrix();
                drawEdgeTable();
            }
        } else {
            console.log('Invalid');
            alert('Đỉnh bạn nhập không tồn tại. Xin hãy nhập lại!');
        }
    } else {
        console.log('Null');
        alert('Xin hãy nhập đầy đủ thông tin!');
    }
}



////////////////////////////////////////////////////////////////////////////////////////////////////////////
function drawEdges() {
    edges.forEach(edge => {
        ctx.beginPath();
        ctx.moveTo(edge.start.x, edge.start.y);
        ctx.lineTo(edge.end.x, edge.end.y);
        ctx.strokeStyle = 'black';
        ctx.stroke();

        // Calculate the midpoint for displaying text
        const midX = (edge.start.x + edge.end.x) / 2;
        const midY = (edge.start.y + edge.end.y) / 2;

        // Display weight and name on the canvas
        ctx.fillStyle = 'black';
        ctx.font = '12px Arial';

        const weightText = edge.weight ? `W: ${edge.weight}` : 'W:Trống';
        const nameText = edge.name ? `N: ${edge.name}` : 'N:Trống';

        ctx.fillText(weightText, midX - 20, midY);
        ctx.fillText(nameText, midX - 20, midY + 15);
    });
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////
function drawMatrix() {
    const matrixTextArea = document.getElementById('matrixTextArea');
    const matrixSize = vertices.length;
    const matrix = Array.from({ length: matrixSize }, () => Array(matrixSize).fill(0));

    edges.forEach(edge => {
        const rowIndex = vertices.indexOf(edge.start);
        const colIndex = vertices.indexOf(edge.end);
        const w = edge.weight ;
        if(edge.weight === ''){
            w = 0;
        }

        matrix[rowIndex][colIndex] = w;
        matrix[colIndex][rowIndex] = w; 

    });

    // Display the matrix in the textarea
    matrixTextArea.value = matrix.map(row => row.join('\t')).join('\n');
    mt = matrixTextArea.value;
    
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////////////////////////////////
function drawEdgeTable() {
    const edgeTable = document.getElementById('edgeTable');
    
    // Clear existing content
    edgeTable.innerHTML = '';

    if (edges.length === 0) {
        return; // No edges to display
    }

    // Create a table header
    const headerRow = document.createElement('tr');
    headerRow.innerHTML = '<th>Đỉnh bắt đầu</th><th>Đỉnh kết thúc</th><th>Tên</th><th>Trọng số</th>';
    edgeTable.appendChild(headerRow);

    edges.forEach(edge => {
        const row = document.createElement('tr');
        const startLabel = edge.start.label || 'Trống';
        const endLabel = edge.end.label || 'Trống'; 
        const name = edge.name || 'Trống';
        const weight = edge.weight || 'Trống'; 

        row.innerHTML = `<td>${startLabel}</td><td>${endLabel}</td><td>${name}</td><td>${weight}</td>`;
        edgeTable.appendChild(row);
    });
}


// Gọi hàm để vẽ bảng khi trang được tải
drawEdgeTable();

////////////////////////////////////////////////////////////////////////////////////////////////////////////


// Lắng nghe sự kiện khi người dùng nhập beginVertex
const beginVertexInput = document.getElementById('beginVertex');
const algorithmResultTextArea = document.getElementById('algorithmResultTextArea');


beginVertexInput.addEventListener('input', function () {
    const beginVertex = vertices.find(vertex => vertex.label === beginVertexInput.value);

    if (beginVertex) {
        const { distances, paths } = findShortestPaths(beginVertex);

        // Hiển thị kết quả trên trang web
        algorithmResultTextArea.value = `Khoảng cách từ ${beginVertex.label} đến các đỉnh khác:\n`;
        for (let i = 0; i < distances.length; i++) {
            if (i !== vertices.indexOf(beginVertex)) {
                const pathIndices = paths[i];
                const path = pathIndices.map(index => vertices[index].label);
                algorithmResultTextArea.value += `${path.join(' -> ')}: ${distances[i]}\n`;
            }
        }
    } else {
        algorithmResultTextArea.value = "Đỉnh không tồn tại trong đồ thị!";
        alert('Đỉnh không tồn tại trong đồ thị!');
    }
});





canvas.addEventListener('click', handleVertexClick);
canvas.addEventListener('mousedown', handleMouseDown);
canvas.addEventListener('mouseup', handleMouseUp);
canvas.addEventListener('mousemove', handleMouseMove);
canvas.addEventListener('contextmenu', handleRightClick);

document.getElementById('center-panel').appendChild(canvas);

