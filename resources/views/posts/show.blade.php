@extends('layouts.app')

@section('content')
{{--        <div class="jumbotron">--}}
{{--            <img src="{{$post->imagePath ?? asset('images/image.jpeg')}}" style="width: 50%;border-radius: 50%" alt="">--}}
{{--            <hr>--}}
{{--            <h1>{{$post->title}}</h1>--}}
{{--            <p>{{$post->body}}</p>--}}
{{--            <small>Written {{$post->created_at->diffForHumans()}} By {{$post->admin->username}}</small>--}}

{{--            @if(\Sentinel::getUser()->hasAnyAccess(['admin.*' , 'moderator.*']))--}}
{{--                <div class="form-group">--}}
{{--                    <a href="{{route('posts.edit' , $post->title)}}" class="form-control">Edit Post</a>--}}
{{--                </div>--}}
{{--            @endif--}}

{{--             @if(\Sentinel::getUser()->hasAccess('admin.delete'))--}}
{{--                <form method="post" action="{{route('posts.destroy' , $post->title)}}">--}}
{{--                    {{csrf_field()}}--}}
{{--                    <input type="hidden" name="_method" value="DELETE">--}}
{{--                    <input type="submit" name="submit" value="Delete" class="form-control">--}}
{{--                </form>--}}
{{--            @endif--}}
{{--            <br>--}}
{{--            @if(Sentinel::getUser()->hasAccess('admin.approve'))--}}
{{--                <form method="post" action="{{route('post.approve' , $post->id)}}">--}}
{{--                    {{csrf_field()}}--}}
{{--                    <input type="submit" name="submit" value="Approve Post" class="form-control">--}}
{{--                </form>--}}
{{--            @endif--}}

{{--        </div>--}}


<div class="col-sm-8">
    <div class="panel panel-white post panel-shadow ">
        <div class="post-heading">
            <div class="pull-left image">
                <img src="{{asset("images/$post->imagePath") ?? asset('images/image.jpeg')}}" class="img-circle avatar" alt="">
            </div>
            <div class="pull-left meta">
                <div class="title h5">
                    <a href=""><b>{{$post->admin->username ?? NULL }}</b></a> Made a post
                    <p><small>{{$post->admin->roles->first()->name}}</small></p>
                </div>
                <h6 class="text-muted time">{{$post->created_at}}</h6>
            </div>
        </div>
        <div class="post-description">
            {{$post->body}}
            <div class="pull-right">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Post Managing
                        <span class="create"></span>
                    </button>
                    <ul class="dropdown-menu">
                        @if($post->approved === 0)
                            @if(Sentinel::getUser()->hasAccess('*.approve'))
                                <li>
                                    <a href="{{ route('post.approve' , $post->id) }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('approve-form').submit();">
                                        Approve Post
                                    </a>

                                    <form id="approve-form" action="{{ route('post.approve' , $post->id) }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            @endif
                        @endif
                        @if(Sentinel::getUser()->hasAccess('*.delete'))
                            <li>
                                <a href="{{ route('posts.destroy' , $post->title) }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('delete-form').submit();">
                                    Delete Post
                                </a>

                                <form id="delete-form" action="{{ route('posts.destroy' , $post->title) }}" method="POST" style="display: none;">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        @endif
                            @if(Sentinel::getUser()->hasAccess('*.edit'))
                            <li>
                                <a href="{{ route('posts.edit' , $post->title) }}">
                                    Edit Post
                                </a>

                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="post-footer">

            <form action="{{route('comments.store' , $post->title)}}" method="POST">
                {{csrf_field()}}
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Add Comment" name="comment" style="height: 50px">
                    <span class="input-group-addon">
                                <a href=""><i class="fa fa-pencil"></i></a>
                            </span>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary form-control">
                        <i class="fa fa-commenting-o" aria-hidden="true"></i>
                        Add Comment
                    </button>
                </div>
            </form>

            @foreach($post->comments as $comment)
                <ul class="comments-list">
                    <li class="comment">
                        <a href="" class="pull-left">
                            <img src="{{asset("images/$comment->post->imagePath") ?? asset('images/image.jpeg')}}" class="img-circle avatar" alt="">
                        </a>
                        <div class="comment-body">
                            <div class="comment-heading">
                                <h4 class="user">{{$comment->user->username  ?? NULL}}</h4>
                                <h5 class="time">{{$comment->created_at->diffForHumans()}}</h5>
                            </div>
                            @if(Route::currentRouteName() == 'comments.edit')
                                @if(request()->route('comment')->id == $comment->id)
                                    <form method="post" action="{{ route('comments.update' ,  $comment->id )  }}">
                                        {{csrf_field()}}
                                        {{method_field('PUT')}}
                                        <input type="text" class="form-control" name="comment" value="{{$comment->body}}">
                                        <hr>
                                        <button type="submit" class="form-control">Update Comment</button>
                                    </form>
                                @else
                                    <p>{{$comment->body}}</p>
                                @endif
                            @else
                                <p>{{$comment->body}}</p>
                            @endif
                            <small>

                                    <a href="{{ route('comments.edit' , ['comment' => $comment->id , 'post' =>$post->title])}}">Edit</a>
                                    |
                                    <a href="{{ route('comments.destroy' , $comment->id) }}"
                                       onclick="event.preventDefault();
                                                 document.getElementById('comment-delete-form').submit();">
                                        Delete Comment
                                    </a>

                                <form id="comment-delete-form" action="{{ route('comments.destroy' , $comment->id) }}" method="POST" style="display: none;">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                </form>

                            </small>
                        </div>

                        <ul class="comment-list">
                            <li class="comment">
                                <form action="{{route('replies.store' , ['comment' =>$comment->id , 'post' =>$post->title])}}" method="post">
                                    {{csrf_field()}}
                                    <div class="input-group">
                                        <span class="input-group-addon"><a href=""><i class="fa fa-pencil"></i></a></span>
                                        <input type="text" name="comment" placeholder="add reply" class="form-control" style="height: 50px;">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit"  class="form-control btn btn-success  " >Reply</button>
                                    </div>
                                </form>

{{--                                {{$comment->replies}}--}}
                                @if($comment->replies)
                                    @foreach($comment->replies as $reply)
                                        <a class="pull-left image">
                                            <img src="{{asset("images/$post->imagePath") ?? asset('images/image.jpeg')}}" class="img-circle avatar" alt="">
                                        </a>
                                        <div class="comment-body">
                                            <div class="comment-heading">
                                                <h4>{{$post->admin->username ?? NULL }}</h4>
                                                <h5>{{$reply->created_at->diffForHumans()}}</h5>
{{--                                                <p>{{$reply->user->roles->first()->name}}</p>--}}
                                            </div>


                                            @if(Route::currentRouteName() == 'replies.edit')
                                                @if(request()->route('reply')->id == $reply->id)
                                                    <form method="post" action="{{ route('replies.update' ,['reply' =>$reply->id ,
                                                        'comment' =>$comment->id , 'post' =>$post->title] )  }}">
                                                        {{csrf_field()}}
                                                        {{method_field('PUT')}}
                                                        <input type="text" class="form-control" name="comment" value="{{$reply->body}}">
                                                        <hr>
                                                        <button type="submit" class="form-control">Update reply</button>
                                                    </form>
                                                @else
                                                    <p>{{$reply->body}}</p>
                                                @endif
                                            @else
                                                <p>{{$reply->body}}</p>
                                            @endif
                                            <small>

                                                <a href="{{ route('replies.edit' , ['reply' => $reply->id , 'post' =>$post->title])}}">Edit</a>
                                                |
                                                <a href="{{ route('replies.destroy' , $reply->id) }}"
                                                   onclick="event.preventDefault();
                                                 document.getElementById('reply-delete-form').submit();">
                                                    Delete reply
                                                </a>

                                                <form id="reply-delete-form" action="{{ route('replies.destroy' , $reply->id) }}" method="POST" style="display: none;">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                </form>

                                            </small>

                                        </div>
                                    @endforeach
                                @endif

                            </li>
                        </ul>

                    </li>
                </ul>
            @endforeach

        </div>
    </div>
</div>


@endsection