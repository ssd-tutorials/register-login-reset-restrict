@extends('template.layout')

@section('content')

    <div data-form-wrapper>

        <form
            method="post"
            action="/register/post"
            data-ajax-form
            data-success-behaviour="redirectOrFadeOut"
            novalidate
        >

            <h1>Register</h1>

            <div class="divider brtd"></div>

            <label for="name">
                Name: *
                <span data-validation="name">
                    <span data-case="required">Please provide your name</span>
                    <span data-case="failed">Record could not be added</span>
                </span>
            </label>
            <input
                type="text"
                name="name"
                id="name"
                data-validate="required"
            >

            <label for="email">
                Email address: *
                <span data-validation="email">
                    <span data-case="required">Please provide your email address</span>
                    <span data-case="email">Invalid email address</span>
                    <span data-case="taken">This email address is already taken</span>
                </span>
            </label>
            <input
                type="email"
                name="email"
                id="email"
                data-validate="required|email"
            >

            <label for="password">
                Password: *
                <span data-validation="password">
                    <span data-case="required">Please provide your password</span>
                    <span data-case="confirmed">Passwords do not match</span>
                </span>
            </label>
            <input
                type="password"
                name="password"
                id="password"
                data-validate="required|confirmed"
            >

            <label for="password_confirmation">
                Confirm password: *
                <span data-validation="password_confirmation">
                    <span data-case="required">Please confirm your password</span>
                </span>
            </label>
            <input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                data-validate="required"
            >

            <input
                type="submit"
                class="button"
                value="REGISTER"
                data-submit-trigger
        >

            <button
                type="button"
                class="button hide"
                disabled
                data-submit-pending
            >
                <i class="fa fa-spinner fa-spin"></i> PROCESSING
            </button>

        </form>

        <p data-confirmation></p>

    </div>

@endsection