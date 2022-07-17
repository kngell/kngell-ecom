let todos;
const saveTodos = JSON.parse(localStorage.getItem("todos"));
if (Array.isArray(saveTodos)) {
  todos = saveTodos;
} else {
  todos = [
    { title: "GetGroceries", dueDate: "2012-2-23", id: "id1" },
    { title: "Wash Car", dueDate: "2022-12-25", id: "id2" },
    { title: "Make Dinner", dueDate: "02-03-2012", id: "id3" },
  ];
}
const button = document.querySelector("#button");
button.addEventListener("click", function () {
  addToto();
});
render();

function addToto() {
  const textbox = document.getElementById("toto-title");
  const datePicker = document.getElementById("date-picker");
  const dueDate = datePicker.value;
  const title = textbox.value;
  createTodo(title, dueDate);
  render();
}
function deleteTodo(e) {
  const deleteButton = e.target;
  const idToDelete = deleteButton.id;
  removeTodo(idToDelete);
  render();
}

function createTodo(title, dueDate) {
  const id = "" + new Date().getTime();
  todos.push({ title: title, dueDate: dueDate, id: id });
  savetodos();
}
function removeTodo(idToDelete) {
  todos = todos.filter(function (todo) {
    return todo.id !== idToDelete;
  });
  savetodos();
}
function savetodos() {
  localStorage.setItem("todos", JSON.stringify(todos));
}

function render() {
  document.getElementById("todo-list").innerHTML = "";
  todos.forEach(function (todo) {
    const todoList = document.getElementById("todo-list");
    const elt = document.createElement("div");
    elt.innerText = todo.title + " " + todo.dueDate;
    const deleteButton = document.createElement("button");
    deleteButton.innerText = "Delete";
    deleteButton.style = "margin-left: 12px";
    deleteButton.onclick = deleteTodo;
    deleteButton.id = todo.id;
    elt.appendChild(deleteButton);
    todoList.appendChild(elt);
  });
}
