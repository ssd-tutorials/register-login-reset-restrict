@extends('template.layout')

@section('content')

    <h1>Forgot password?</h1>

    <div data-form-wrapper>

        <form
            method="post"
            action="/forgot/post"
            data-ajax-form
            data-success-behaviour="fadeOutShowMessage"
            novalidate
        >

            <p>
                To reset your password please first provide your registered email address and press SUBMIT button below.
            </p>

            <div class="divider brtd"></div>

            <label for="email">
                Email address: *
                <span data-validation="email">
                    <span data-case="required">Please provide your email address</span>
                    <span data-case="email">Invalid email address</span>
                    <span data-case="invalid">Email not found</span>
                    <span data-case="technical">Technical problem</span>
                </span>
            </label>
            <input
                type="email"
                name="email"
                id="email"
                data-validate="required|email"
            >

            <input
                type="submit"
                class="button"
                value="SUBMIT"
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