<form action="{{ $actionRoute }}" method="POST" enctype="multipart/form-data" class="form-wrapper">
    @csrf
    @if(strtoupper($method) !== 'POST')
        @method($method)
    @endif

    @if($errors->any())
        <div class="error">
            <ul style="margin:0; padding-left:1.2rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="field-group">
        <label for="title">Title <span style="color:#b91c1c">*</span></label>
        <input type="text" id="title" name="title"
               value="{{ old('title', $project->title ?? '') }}" required>
    </div>

    <div class="field-group">
        <label for="description">Description</label>
        <textarea id="description" name="description"
                  rows="4">{{ old('description', $project->description ?? '') }}</textarea>
    </div>

    <div class="field-group">
        <label for="status">Status <span style="color:#b91c1c">*</span></label>
        <select id="status" name="status"
                style="width:100%; border:1px solid #d1d5db; padding:10px; border-radius:4px; box-sizing:border-box;">
            @foreach(['active' => 'Active', 'in_progress' => 'In Progress', 'completed' => 'Completed', 'on_hold' => 'On Hold'] as $value => $label)
                <option value="{{ $value }}"
                    @selected(old('status', $project->status ?? 'active') === $value)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="field-group">
        <label for="due_date">Due Date</label>
        <input type="date" id="due_date" name="due_date"
               value="{{ old('due_date', $project->due_date ?? '') }}">
    </div>

    <div class="field-group">
        <label>Assigned to <span style="color:#b91c1c">*</span></label>
        @php
            $assigned = old('collaborators', isset($project->assigned_to)
                ? explode(',', $project->assigned_to) : []);
        @endphp
        <div class="checkbox-group">
            @foreach($collaborators as $collaborator)
                <label class="checkbox-item" style="display:block; margin-bottom:6px;">
                    <input type="checkbox" name="collaborators[]"
                           value="{{ $collaborator }}"
                           @if(in_array($collaborator, $assigned)) checked @endif>
                    {{ $collaborator }}
                </label>
            @endforeach
        </div>
    </div>

    <div class="field-group">
        <label for="thumbnail">Thumbnail</label>
        <input type="file" id="thumbnail" name="thumbnail" accept="image/*">

        @if(!empty($project->thumbnail ?? null))
            <div style="margin-top:10px;">
                <p style="margin:0 0 6px; font-size:0.875rem;">Current thumbnail:</p>
                <img src="{{ asset('storage/' . $project->thumbnail) }}"
                     alt="Project thumbnail"
                     style="max-width:180px; max-height:120px; border:1px solid #d1d5db; border-radius:4px; display:block; margin-bottom:8px;">
                <label style="font-weight:400; display:flex; align-items:center; gap:6px;">
                    <input type="checkbox" name="remove_thumbnail" value="1"
                           @checked(old('remove_thumbnail'))>
                    Remove current thumbnail
                </label>
            </div>
        @endif
    </div>

    <div style="display:flex; gap:8px; margin-top:8px;">
        <button type="submit" class="button">Save</button>
        <a class="button secondary" href="{{ route('projects.index') }}">Cancel</a>
    </div>
</form>