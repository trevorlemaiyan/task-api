<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
</head>
<body>
    <div id="app" class="container" v-cloak>
        <header><h1>Task Manager</h1></header>
        <section class="card">
            <h2>Add New Task</h2>
            <form @submit.prevent="addTask" class="task-form">
                <input v-model="newTask.title" type="text" placeholder="Task Title" required>
                <input v-model="newTask.due_date" type="date" required>
                <select v-model="newTask.priority" required>
                    <option value="" disabled>Priority</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
                <button type="submit" class="btn btn-primary">Add Task</button>
            </form>
            <p v-if="error" class="error-text">@{{ error }}</p>
        </section>
        <section class="card">
            <h2>Current Tasks</h2>
            <ul class="task-list">
                <li v-for="task in tasks" :key="task.id" class="task-item">
                    <div class="task-info">
                        <h3>@{{ task.title }}</h3>
                        <div class="task-meta">
                            <span>Due: @{{ task.due_date }}</span>
                            <span :class="['badge', 'priority-' + task.priority]">@{{ task.priority }}</span>
                        </div>
                    </div>
                    <div class="task-actions">
                        <span :class="['status-label', 'status-' + task.status]">@{{ task.status.replace('_', ' ') }}</span>
                        <button v-if="task.status === 'pending'" @click="updateStatus(task.id, 'in_progress')" class="btn btn-sm btn-outline-blue">Start</button>
                        <button v-if="task.status === 'in_progress'" @click="updateStatus(task.id, 'done')" class="btn btn-sm btn-outline-green">Finish</button>
                        <button v-if="task.status === 'done'" @click="deleteTask(task.id)" class="btn btn-sm btn-outline-red">Delete</button>
                    </div>
                </li>
            </ul>
        </section>
    </div>
    <script src="/js/app.js"></script>
</body>
</html>