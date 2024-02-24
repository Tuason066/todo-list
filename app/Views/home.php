<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- tailwindcss -->
    <link rel="stylesheet" href="/styles/output.css">
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body>

    <section class="py-12">
        <h1 class="text-center mb-8 font-extrabold text-2xl md:text-4xl text-blue-500"><span class="uppercase">todo</span> List</h1>

        <div class="w-11/12 mx-auto max-w-96">
            <!-- alert message -->
            <p id="alert-message" class="opacity-100 p-2 mb-2 text-center rounded text-white text-sm transition-all">alert message</p>

            <form id="todoForm" method="post" class="flex items-start gap-x-2 mb-4">
                <!-- input field for todos -->
                <input name="todo" id="todo" class="mb-1 block shadow appearance-none border-2 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="e.g. learn PHP" required>
                <button type="submit" id="addTodoBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all">Add</button>
                
                <div class="gap-x-2 transition-all w-0 flex overflow-x-hidden" id="editContainer">
                    <!-- tried button to submit data -->
                    <button type="button" id="submitEditTodoBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</button>
                    <button type="button" id="cancelTodoBtn" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Cancel</button>
                </div>
            </form>

            <ul id='hello' data-id='container'></ul>
        </div>
    </section>

    <script>

        $(document).ready(function() {

            let editId = null;

            let timeoutId;
            const handleAlertMessage = (message, status = 0) => {

                clearTimeout(timeoutId);

                $('#alert-message')[0].className = "opacity-100 p-2 mb-2 text-center rounded text-white text-sm transition-all";
                $('#alert-message')[0].textContent = message;

                if(status) {
                    $('#alert-message')[0].classList.add('bg-green-500');
                } else {
                    $('#alert-message')[0].classList.add('bg-red-500');
                }

                timeoutId = setTimeout(() => {
                    $('#alert-message')[0].className = 'opacity-0 p-2 mb-2 text-center rounded text-white text-sm transition-all';
                }, 1000);
            }

            // handle todos UI
            const handleTodosUI = (data = []) => {
                const container = $('[data-id="container"]')[0];

                const content = data.map(({id, name}, index) => {
                    const bgColor = index % 2 ? 'bg-sky-50' : 'bg-blue-200';

                    return `<li id="item" class="${bgColor} flex justify-between items-center">
                                <p data-id="${id}" class="p-2">${name}</p>
                                <div class="flex items-center gap-x-2">
                                    <button type="button" id="editBtn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><g fill="#0fd236" fill-rule="evenodd" clip-rule="evenodd"><path d="M11.3 6.2H5a2 2 0 0 0-2 2V19a2 2 0 0 0 2 2h11c1.1 0 2-1 2-2.1V11l-4 4.2c-.3.3-.7.6-1.2.7l-2.7.6c-1.7.3-3.3-1.3-3-3.1l.6-2.9c.1-.5.4-1 .7-1.3l3-3.1Z"/><path d="M19.8 4.3a2.1 2.1 0 0 0-1-1.1a2 2 0 0 0-2.2.4l-.6.6l2.9 3l.5-.6a2.1 2.1 0 0 0 .6-1.5c0-.2 0-.5-.2-.8m-2.4 4.4l-2.8-3l-4.8 5l-.1.3l-.7 3c0 .3.3.7.6.6l2.7-.6l.3-.1l4.7-5Z"/></g></svg>
                                    </button>
                                    <button type="button" id="deleteBtn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="#e01a1a" d="M19 4h-3.5l-1-1h-5l-1 1H5v2h14M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6z"/></svg>
                                    </button>
                                </div>
                            </li>
                    `;
                }).join('');

                container.innerHTML = content;

                const todosItem = document.querySelectorAll('#item');
                
                todosItem.forEach(item => {
                    const id = parseInt(item.querySelector("p").dataset.id);
                    const name = item.querySelector('p').textContent;
                    const deleteBtn = item.querySelector('#deleteBtn');
                    const editBtn = item.querySelector("#editBtn");

                    editBtn.addEventListener('click', (e) => {

                        $('#todo').val(name);
                        // edit container buttons
                        $('#editContainer')[0].classList.remove("w-0");
                        $('#editContainer')[0].classList.add("w-[17.7rem]");
                        // add button
                        $('#addTodoBtn')[0].classList.add('w-0');
                        $('#addTodoBtn')[0].classList.remove('py-2');
                        $('#addTodoBtn')[0].classList.remove('px-4');
                        $('#addTodoBtn')[0].setAttribute("disabled", "true");

                        editId = id;

                        // cancel edit
                        $('#cancelTodoBtn')[0].addEventListener('click', () => {
                            // UI

                            // edit button container
                            $('#editContainer')[0].classList.remove("w-[17.7rem]");
                            $('#editContainer')[0].classList.add("w-0");
                            // add button
                            $('#addTodoBtn')[0].classList.remove('w-0')
                            $('#addTodoBtn')[0].classList.add('py-2')
                            $('#addTodoBtn')[0].classList.add('px-4')
                            $('#addTodoBtn')[0].removeAttribute("disabled");
                            $('#todo').val("");
                        })
                    })


                    deleteBtn.addEventListener('click', () => {
                        $.ajax({
                            url: '<?= base_url() ?>'+'deleteTodoById/'+id,
                            type: 'POST',
                            success: function(response) {
                                // Handle success response
                                handleTodosUI(JSON.parse(response));
                                handleAlertMessage("Item Deleted", 0);

                                // edit button container
                                $('#editContainer')[0].classList.remove("w-[17.7rem]");
                                $('#editContainer')[0].classList.add("w-0");
                                // add button
                                $('#addTodoBtn')[0].classList.remove('w-0')
                                $('#addTodoBtn')[0].classList.add('py-2')
                                $('#addTodoBtn')[0].classList.add('px-4')
                                $('#addTodoBtn')[0].removeAttribute("disabled");
                                $('#todo').val("");
                            },
                            error: function(xhr, status, error) {
                                // Handle error
                                handleAlertMessage(error);
                            },
                            cache: false,
                            processData:false,
                            contentType:false
                        });
                    })
                })

            }

            $('#submitEditTodoBtn')[0].click(() => {

                const name = $('#todo').val();

                $.ajax({
                    url: '<?= base_url() ?>'+'editTodoById',
                    type: 'POST',
                    data: {"id": editId, name},
                    success: function(response) {

                        if(JSON.parse(response).error) {
                            handleAlertMessage(JSON.parse(response).error);
                        } else {

                            $('#todo').val("");

                            handleTodosUI(JSON.parse(response));
                            handleAlertMessage('Item Edit Successfully', 1);

                            /* edit button container */
                            $('#editContainer')[0].classList.remove("w-[17.7rem]");
                            $('#editContainer')[0].classList.add("w-0");
                            /* add button */
                            $('#addTodoBtn')[0].classList.remove('w-0')
                            $('#addTodoBtn')[0].classList.add('py-2')
                            $('#addTodoBtn')[0].classList.add('px-4')
                            $('#addTodoBtn')[0].removeAttribute("disabled");
                        }

                    },
                    error: function(xhr, status, error) {
                        handleAlertMessage(error);
                    },
                    cache: false,
                    processData: true,
                    contentType:'application/x-www-form-urlencoded; charset=UTF-8'
                });
            })

            // handle get all todo
            const handleGetAllTodo = () => {
                $.ajax({
                    url: '<?= base_url('getTodos') ?>',
                    type: 'GET',
                    success: function(response) {
                        handleTodosUI(JSON.parse(response));
                    },
                    error: function(xhr, status, error) {
                        handleAlertMessage(error);
                    },
                    cache: false,
                    processData:false,
                    contentType:false
                });
            };

            handleGetAllTodo();

            // fetch todo by id
            $('#getTodoById').on('click', function(e) {

                const todoId = parseInt($("#todoInput").val());

                $.ajax({
                    url: '<?= base_url() ?>'+'getTodoById/'+todoId,
                    type: 'POST',
                    success: function(response) {
                        // Handle success response
                        console.log(JSON.parse(response));
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        handleAlertMessage(error);
                    },
                    cache: false,
                    processData:false,
                    contentType:false
                });
            });

            // submit/add todo
            $('#todoForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: '<?= base_url('create') ?>',
                    type: 'POST',
                    data: new FormData($(this)[0]),
                    success: function(response) {
                        // Handle success response
                        if(JSON.parse(response).error) {
                            handleAlertMessage(JSON.parse(response).error);
                        } else {
                            handleAlertMessage('Successfully Added New Task', 1);
                            handleTodosUI(JSON.parse(response));
                            $("#todo").val('');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        handleAlertMessage(error);
                    },
                    cache: false,
                    processData:false,
                    contentType:false
                });
            });

        });
    </script>
</body>
</html>