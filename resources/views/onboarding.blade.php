@extends('layouts.home')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <article class="home">
                    <section class="onboarding-madlib">
                        <h1>Financial Life</h1>
                        <form method="POST" action="{{ url('onboarding') }}" class="form-horizontal">
                            @include('common.errors')

                            {{ csrf_field() }}

                            <h2>
                                <span class="edit-age">I am
                                    <input type="text" placeholder="" maxlength="3" name="age" id="age" class="enter-age age border">
                                    <span class="madlib-error"></span>
                                    years old
                                    <section class="selector-container">
                                        <select name="gender" class="cs-select cs-skin-underline">
                                            <option value="1">woman</option>
                                            <option value="2">man</option>
                                            <option value="3">other</option>
                                        </select>
                                    </section>
                                </span>

                                <span class="text">and, I am</span>
                                    <section class="selector-container">
                                        <select name="marital_status" class="cs-select cs-skin-underline">
                                            <option value="1">Single</option>
                                            <option value="2">Married</option>
                                            <option value="3">Divorced</option>

                                        </select>
                                    </section>
                                <br>
                                My annual income is $
                                <span class="nowrap">
                                    <input type="text" placeholder="" maxlength="10" name="income" id="income" class="enter-income border">.
                                </span>
                            </h2>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fa fa-chevron-right"></i> Continue
                                    </button>
                                </div>
                            </div>
                        </form>
                    </section>
                </article>
            </div>
        </div>
    </div>
@endsection