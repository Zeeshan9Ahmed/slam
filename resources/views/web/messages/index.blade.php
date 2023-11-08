@extends('layout.master')
@section('content')
<div class="messagesRow d-flex">
    <div class="leftCol">
        <div class="chatBox">
            <p class="topHead">Chats</p>
            <div class="msgInner">
                <form class="searchBar">
                    
                    <div class="form-group relClass">
                        <input type="search" class="msgSearch" id="search" placeholder="Search">
                        <a id="magnifying" class="srchBtn xy-center"><i class="fa-solid fa-magnifying-glass"></i></a>
                    </div>
                  
                    @if (count($chat_list) == 0)
                    <p class="noChat xy-center">User's chat will appear here.</p>
                    @endif
                    <div class="memberWrap mt-2" id="inbox_html">
                        @if ($user)
                        @if(!collect($chat_list)->contains('id', $user_id))
                        <div class="memeberItem chat" data-id="{{$user->id}}" data-name="{{$user->full_name}}">
                            <div class="imgBox">
                                <img src="{{$user->avatar??asset('assets/images/avatar.png')}}" width="50px" height="50px" alt="img">

                            </div>
                            <div class="textBox">
                                <p class="name">{{$user->full_name}}</p>
                                <p class="desc">No Chat....</p>
                                <p class="date">---</p>
                            </div>
                        </div>
                        @endif
                        @endif
                        @foreach($chat_list as $inbox)
                        <div class="memeberItem chat" data-id="{{$inbox->id}}" data-name="{{$inbox->full_name}}">
                            <div class="imgBox">
                            <a href="{{url('admin/user', $inbox->id)}}">
                                <img src="{{$inbox->avatar??asset('assets/images/avatar.png')}}"  width="50px" height="50px" alt="img">
                            </a>
                            </div>
                            <div class="textBox">
                                <p class="name">{{$inbox->full_name}}</p>
                                @if($inbox->chat_type == 'text')
                                <p class="desc">{{$inbox->chat_message}}</p>
                                @else
                                <p class="desc"><i class="fa-solid fa-image"></i> </p>
                                @endif
                                <p class="date">{{$inbox->created_at}}</p>
                            </div>
                        </div>
                        @endforeach







                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="rightCol">
        <div class="chatBox">
            <p class="topHead" id="user_name"></p>
            <div class="chatBody">
                <div class="messages-box" id="chat-html">
                    <div class="chatNull xy-center">
                        <img src="{{asset('assets/images/chat-demo.png')}}" alt="img" class="img-fluid">

                        <p class="desc pt-3">No messages, new messages will appear here</p>
                    </div>
                </div>
            </div>
            <div class="writeMsg d-none relClass">
                <div id="image-container"></div>
                <form enctype="multipart/form-data" id="upload_form">
                    @csrf
                    <div class="form-group relClass">
                        <input type="hidden" id="reciever_id" value="" />
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <input type="text" class="msgWriter" id="message" placeholder="Type a message.....">
                        <label for="image-upload" class="attachIcon xy-center">
                            <i class="fa-solid fa-paperclip"></i>
                            <input type="file" id="image-upload" name="avatar" class="d-none">
                        </label>
                        <button class="genBtn sendBtn">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('additional_scripts')
<script src="https://cdn.socket.io/4.4.1/socket.io.min.js" integrity="sha384-fKnu0iswBIqkjxrhQCTZ7qlLHOFEgNkRmK2vaO/LbTZSXdJfAu6ewRBdwHPhBo/H" crossorigin="anonymous"></script>
<script>
    const imageUpload = document.getElementById('image-upload');
    const imageContainer = document.getElementById('image-container');
    imageUpload.addEventListener('change', function() {
        // alert(1)
        document.getElementById("message").disabled = true;
        document.getElementById("message").value = '';
        const file = this.files[0];
        const reader = new FileReader();
        reader.addEventListener('load', function() {
            const imagePreview = document.createElement('div');
            imagePreview.classList.add('image-preview');
            const image = document.createElement('img');
            image.setAttribute('src', this.result);
            imagePreview.appendChild(image);
            const removeButton = document.createElement('button');
            removeButton.classList.add('remove-image');
            removeButton.innerHTML = '&times;';
            removeButton.addEventListener('click', function() {

                document.getElementById("image-upload").value = '';

                document.getElementById("message").disabled = false;

                imagePreview.remove();
            });
            imagePreview.appendChild(removeButton);
            imageContainer.innerHTML = '';
            imageContainer.appendChild(imagePreview);
        });
        reader.readAsDataURL(file);
    });
</script>
<script>
    $(document).ready(function() {


        var users = <?php echo json_encode($chat_list); ?>;

        const filterItems = (needle, heystack) => {
            let query = needle.toLowerCase();
            return heystack.filter(item => item.full_name?.toLowerCase().indexOf(query) >= 0);
        }

        $('#search').keyup(function(e) {
            if (e.keyCode == 8) {
                search = $('#search').val()
                $('#inbox_html').html(generateChatInbox(filterItems(search, users)))
            }
        })

        $(document).on('click', '#magnifying', function() {
            // console.log(users)
            search = $('#search').val()
            if (!search) {
                not('Field Can not be empty', 'error')
                return;
            }
            let data = filterItems(search, users);

            $('#inbox_html').html(generateChatInbox(data))
        });

        function generateChatInbox(data) {
            var users_html = '';

            if (data.length == 0) {
                users_html =
                    `<p class="noChat xy-center">User Not Found</p>`;
            }
            console.log(data,'data')
            $(data).each(function(index, user) {
                var url = user.avatar;
                var dummyUrl = "{{asset('assets/images/avatar.png')}}"
                users_html +=
                    `<div class="memeberItem chat" data-id="${user.id}" data-name="${user.full_name}">
                            <div class="imgBox">
                                <img src="${url??dummyUrl}" width="50px" height="50px" alt="img">

                            </div>
                            <div class="textBox">
                                <p class="name">${user.full_name}</p>
                                <p class="desc">${user.chat_type=="text"?user.chat_message:'<i class="fa-solid fa-image"></i> '}</p>
                                <p class="date">${user.created_at} </p>
                            </div>
                        </div>`;
            })
            return users_html;
        }


        $('#search').keypress(function(event) {
            if (event.keyCode === 10 || event.keyCode === 13) {
                event.preventDefault();
                search = $('#search').val()
                $('#inbox_html').html(generateChatInbox(filterItems(search, users)))
            }
        });
        $(document).on('click', '.sendBtn', function(e) {
            e.preventDefault()
            var message = $("#message").val();
            var sender_id = "{{auth()->id()}}";
            var reciever_id = $("#reciever_id").val();
            data = new FormData();
            data.append('avatar', $('#image-upload')[0].files[0]);
            var imgname = $('input[type=file]').val();
            if (!imgname && !message) {
                not('Message Can not be Empty', 'error')
                return;
            }
            if (imgname) {
                $.ajax({
                    url: "{{url('admin/message/uploadimage')}}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    enctype: 'multipart/form-data',
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType
                    success: function(data) {
                        if (data.status == 1) {
                            response = data.data;
                            message = response.imageName
                            socket.emit("send_message", {
                                sender_id: sender_id,
                                reciever_id: reciever_id,
                                message: message,
                                chat_type: 'file'
                            });
                        } else if (data.status == 0) {
                            not(data.message, 'error');
                        }
                    },
                    error: function(error) {
                        console.log(error, 'dfasf');
                    }
                });
            } else {
                // console.log('dasfafd')
                // return;
                socket.emit("send_message", {
                    sender_id: sender_id,
                    reciever_id: reciever_id,
                    message: message,
                    chat_type: 'text'
                });
            }
        })
        // const socket = io.connect("http://localhost:3003");

        const socket = io.connect("https://server1.appsstaging.com:3075");
        socket.on("connect", () => {
            console.log(socket.connected); // true
        });

        socket.on("error", (error_messages) => {
            not('Something went wrong', 'error');
        });



        socket.on("disconnect", () => {
            console.log(socket.connected); // false
        });



        user_id = "{{$user_id}}"

        if (user_id) {
            $('.writeMsg').addClass('d-block')
            $('.writeMsg').removeClass('d-none')
            reciever_id = user_id
            user_name = "{{$user->full_name??''}}"
            sender_id = "{{auth()->id()}}"
            socket.emit('get_messages', {
                "sender_id": sender_id,
                "reciever_id": reciever_id,
            });

            $("#user_name").html(user_name)
            $("#reciever_id").val(reciever_id)


        }

        $(document).on('click', '.chat', function() {
            
            // writeMsg
            $('.writeMsg').addClass('d-block')
            $('.writeMsg').removeClass('d-none')
            reciever_id = $(this).attr('data-id')
            user_name = $(this).attr('data-name')
            
            sender_id = "{{auth()->id()}}"
            // console.log(reciever_id , user_name , sender_id )
            socket.emit('get_messages', {
                "sender_id": sender_id,
                "reciever_id": reciever_id,
            });

            $("#user_name").html(user_name)
            $("#reciever_id").val(reciever_id)




        });
        var msg = $('#mSg').val();
        var color = $('#mSg').attr('color');

        if (msg) {
            not(msg, color);
        }





        socket.on("error", (messages) => {
            // console.log('messages *** ', messages);
        })

        socket.on("response", (messages) => {
            // append single msg for chat
            console.log(messages,'messages')
            if (messages.object_type == "get_message") {

                let val = messages.data;
                // chat_type
                if (val.chat_type == 'file') {
                    $('.image-preview').remove()
                    $("#image-upload").val('');
                    $("#message").prop("disabled", false);
                }
                $("#message").val('');
                let html = '';
                if (val.chat_sender_id == "{{auth()->id()}}") {
                    var class_name = 'sender';
                    
                } else {
                    var class_name = 'receiver';
                }

                var message = "";
                if (val.chat_type == "file") {
                    base_url = "{{asset('')}}" + "/" +  val.chat_message;
                    message = `<img src="${base_url}" alt="img" class="imgMem msgImage">`;

                } else {
                    message = val.chat_message;
                }

                var url = val.avatar;
                var dummyUrl = "{{asset('assets/images/avatar.png')}}"


                html +=
                    `<div class="msgBox ${class_name}">
                        <p class="chatText">
                           ${message}
                            <span class="time">${formatAMPM(val.created_at)}</span>
                        </p>
                        <img src="${url??dummyUrl}" alt="img" class="imgMem">
                    </div>`;
                $('#chat-html').append(html);

            } else if (messages.object_type == "get_messages") {
                // all chat append
                // console.log(messages)
                var html = '';
                $(messages.data).each(function(i, val) {
                    if (val.chat_sender_id == "{{auth()->id()}}") {
                        var class_name = 'sender';

                    } else {
                        var class_name = 'receiver';
                    }
                    var message = "";
                    if (val.chat_type == "file") {
                        base_url = "{{asset('')}}" + "/" +val.chat_message;
                        message = `<img src="${base_url}" alt="img" class="imgMem msgImage">`;

                    } else {
                        message = val.chat_message;
                    }

                    var url = val.avatar;
                    var dummyUrl = "{{asset('assets/images/avatar.png')}}"

                    html +=
                        `<div class="msgBox ${class_name}">
                        <p class="chatText">
                           ${message}
                            <span class="time">${formatAMPM(val.created_at)}</span>
                            
                        </p>
                        <img src="${url??dummyUrl}" alt="img" class="imgMem">
                    </div>`;



                });


                $("#chat-html").html(html);
            }

        });

        function formatAMPM(date) {
            date = new Date(date);
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0' + minutes : minutes;
            var strTime = hours + ':' + minutes + ' ' + ampm;
            return strTime;
        }



    });

    function not(msg, color) {
        notif({
            msg: "</b>" + msg + " ",
            type: color
        });
    }
</script>

<script>



</script>
@endsection