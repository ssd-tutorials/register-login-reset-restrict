@extends('template.layout')

@section('content')

    <h1>Reset password</h1>

    <div data-form-wrapper>

        <form
            method="post"
            action="/reset/post?token=[token]"
            data-ajax-form
            data-success-behaviour="fadeOutShowMessage"
            novalidate
        >

            <label for="password">
                New password: *
                <span data-validation="password">
                    <span data-case="required">Please provide your new password</span>
                    <span data-case="confirmed">Passwords do not match</span>
                    <span data-case="token">Invalid token</span>
                    <span data-case="failed">Password could not be updated</span>
                </span>
            </label>
            <input
                type="password"
                name="password"
                id="password"
                data-validate="required|confirmed"
            >

            <label for="password_confirmation">
                Confirm new password: *
                <span data-validation="password_confirmation">
                    <span data-case="required">Please confirm your new password</span>
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
                value="UPDATE"
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