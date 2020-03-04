<template>
    <div class="card">
        <h5 class="card-header">{{ 'personal_data'|trans }}</h5>
        <div class="card-body">
            <div class="form-group">
                <label for="inputEmail">{{ 'username'|trans }}</label>
                <input value="{{ user.email }}" id="inputEmail" type="email" name="email" data-parsley-trigger="change" required="" placeholder="{{ 'username'|trans }}" autocomplete="off" class="form-control">
            </div>

            <div class="form-group">
                <label for="inputPassword">{{ 'password'|trans }}</label>
                <input value="********" id="inputPassword" type="password" placeholder="{{ 'password'|trans }}" required="" class="form-control">
            </div>

            <div class="form-group">
                <label for="inputSname">{{ 'sname'|trans }}</label>
                <input value="{{ user.sname }}" id="inputSname" data-parsley-trigger="change" required="" placeholder="{{ 'sname'|trans }}" autocomplete="off" class="form-control">
            </div>

            <div class="form-group">
                <label for="inputFname">{{ 'fname'|trans }}</label>
                <input value="{{ user.fname }}" id="inputFname" data-parsley-trigger="change" required="" placeholder="{{ 'fname'|trans }}" autocomplete="off" class="form-control">
            </div>

            <div class="form-group">
                <label for="inputMname">{{ 'mname'|trans }}</label>
                <input value="{{ user.mname }}" id="inputMname" data-parsley-trigger="change" required="" placeholder="{{ 'mname'|trans }}" autocomplete="off" class="form-control">
            </div>

            <div class="row">
                <div class="col-sm-6 pb-2 pb-sm-4 pb-lg-0 pr-0">
                    <button type="submit" data-url="{{ path('change-personal-data') }}" class="btn btn-space btn-primary">{{ 'save'|trans }}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

</script>