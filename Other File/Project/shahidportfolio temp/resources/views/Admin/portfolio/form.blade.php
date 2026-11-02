@extends('Admin.template')

@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">{{ $item->exists ? 'Edit' : 'Create' }} {{ $config['title'] }}</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.portfolio.index', $resource) }}" class="btn btn-sm btn-success">All</a>
                </div>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    action="{{ $item->exists ? route('admin.portfolio.update', [$resource, $item->id]) : route('admin.portfolio.store', $resource) }}"
                    method="post">
                    @csrf
                    @if ($item->exists)
                        @method('PUT')
                    @endif

                    <div class="row">
                        @foreach ($config['fields'] as $field)
                            @php
                                $value = old($field, is_array($item->{$field}) ? implode(PHP_EOL, $item->{$field}) : $item->{$field});
                                $label = ucwords(str_replace('_', ' ', $field));
                            @endphp
                            <div class="{{ in_array($field, ['about_summary', 'about_description', 'about_extra_description', 'skills_intro', 'resume_intro', 'portfolio_intro', 'contact_intro', 'map_embed_url', 'description', 'bullets'], true) ? 'col-md-12' : 'col-md-6' }} mb-3">
                                @if ($field === 'portfolio_profile_id')
                                    <label>{{ $label }}</label>
                                    <select name="{{ $field }}" class="form-control">
                                        @foreach ($options['profiles'] as $id => $name)
                                            <option value="{{ $id }}" @selected((string) $value === (string) $id)>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                @elseif ($field === 'resume_section_id')
                                    <label>{{ $label }}</label>
                                    <select name="{{ $field }}" class="form-control">
                                        @foreach ($options['resumeSections'] as $id => $name)
                                            <option value="{{ $id }}" @selected((string) $value === (string) $id)>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                @elseif ($field === 'portfolio_category_id')
                                    <label>{{ $label }}</label>
                                    <select name="{{ $field }}" class="form-control">
                                        <option value="">None</option>
                                        @foreach ($options['portfolioCategories'] as $id => $name)
                                            <option value="{{ $id }}" @selected((string) $value === (string) $id)>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                @elseif (in_array($field, ['is_active', 'is_mobile'], true))
                                    <div class="form-check mt-4">
                                        <input type="hidden" name="{{ $field }}" value="0">
                                        <input type="checkbox" name="{{ $field }}" value="1" class="form-check-input"
                                            id="{{ $field }}" @checked((bool) $value)>
                                        <label class="form-check-label" for="{{ $field }}">{{ $label }}</label>
                                    </div>
                                @elseif ($field === 'column')
                                    <label>{{ $label }}</label>
                                    <select name="{{ $field }}" class="form-control">
                                        <option value="left" @selected($value === 'left')>Left</option>
                                        <option value="right" @selected($value === 'right')>Right</option>
                                    </select>
                                @elseif ($field === 'birthday')
                                    <label>{{ $label }}</label>
                                    <input type="date" name="{{ $field }}" class="form-control"
                                        value="{{ optional($item->{$field})->format('Y-m-d') ?: $value }}">
                                @elseif (in_array($field, ['about_summary', 'about_description', 'about_extra_description', 'skills_intro', 'resume_intro', 'portfolio_intro', 'contact_intro', 'map_embed_url', 'description', 'bullets', 'message'], true))
                                    <label>{{ $label }}</label>
                                    <textarea name="{{ $field }}" class="form-control" rows="4">{{ $value }}</textarea>
                                @else
                                    <label>{{ $label }}</label>
                                    <input type="{{ in_array($field, ['age', 'percentage', 'sort_order'], true) ? 'number' : 'text' }}"
                                        name="{{ $field }}" class="form-control" value="{{ $value }}">
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
