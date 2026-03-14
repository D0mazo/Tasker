<?php

session_start();

if(!isset($_SESSION["user"])){
    header("Location:login.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Task Planner</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="topbar">

    <h1>Task Planner</h1>

    <a href="logout.php">Logout</a>

</div>

<div class="container">

    <div class="task-form">

        <h2>Add Task</h2>

        <form id="taskForm">

            <input type="text" id="name" placeholder="Task name" required>

            <input type="date" id="deadline" required>

            <input type="number" id="hours" placeholder="Total hours needed" required>

            <input type="number" id="done" placeholder="Hours done" value="0">

            <button>Add Task</button>

        </form>

    </div>

    <div class="task-list">

        <h2>Tasks</h2>

        <table>

            <thead>
            <tr>
                <th>Name</th>
                <th>Deadline</th>
                <th>Total</th>
                <th>Done</th>
                <th>Progress</th>
                <th>Left</th>
                <th>Daily hours needed</th>
                <th>Delete</th>
            </tr>
            </thead>

            <tbody id="taskTable"></tbody>

        </table>

    </div>

</div>

<script>

    document.getElementById("taskForm").addEventListener("submit",function(e){

        e.preventDefault()

        fetch("backend.php",{
            method:"POST",
            headers:{"Content-Type":"application/json"},
            body:JSON.stringify({
                action:"add",
                name:name.value,
                deadline:deadline.value,
                hours:hours.value,
                done:done.value
            })
        }).then(()=>loadTasks())

    })


    function deleteTask(i){

        fetch("backend.php",{
            method:"POST",
            headers:{"Content-Type":"application/json"},
            body:JSON.stringify({
                action:"delete",
                index:i
            })
        }).then(()=>loadTasks())

    }


    function loadTasks(){

        fetch("backend.php?action=list")
            .then(res=>res.json())
            .then(tasks=>{

                let html=""

                tasks.forEach((t,i)=>{

                    html+=`
<tr>

<td>${t.name}</td>
<td>${t.deadline}</td>
<td>${t.hours}</td>
<td>${t.done}</td>

<td>
<div class="progress">
<div class="bar" style="width:${t.progress}%">${t.progress}%</div>
</div>
</td>

<td>${t.left}</td>

<td>${t.daily}</td>

<td>
<button onclick="deleteTask(${i})">X</button>
</td>

</tr>
`

                })

                taskTable.innerHTML=html

            })

    }

    loadTasks()

</script>

</body>
</html>