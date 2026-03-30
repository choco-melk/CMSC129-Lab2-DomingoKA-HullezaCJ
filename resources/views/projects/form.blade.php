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
        <input type="text" id="title" name="title" value="{{ old('title', $project->title ?? '') }}" required>
    </div>

    <div class="field-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4">{{ old('description', $project->description ?? '') }}</textarea>
    </div>

    <div class="field-group">
        <label>Assigned to <span style="color:#b91c1c">*</span></label>
        @php
            $assigned = old('collaborators', isset($project->assigned_to) ? explode(',', $project->assigned_to) : []);
        @endphp
        <div class="checkbox-group">
            @foreach($collaborators as $collaborator)
                <label class="checkbox-item"><input type="checkbox" name="collaborators[]" value="{{ $collaborator }}"
                    @if(in_array($collaborator, $assigned)) checked @endif
                > {{ $collaborator }}</label>
            @endforeach
        </div>
    </div>

    <div class="field-group">
        <label for="thumbnail">Thumbnail (optional)</label>
        <input type="file" id="thumbnail" name="thumbnail" accept="image/*">
        @if(!empty($project->thumbnail ?? null))
            <div style="margin-top:8px;">Current thumbnail:<br><img src="{{ asset('storage/' . $project->thumbnail) }}" alt="Project thumbnail" style="max-width:180px;max-height:120px;border-radius:4px;"></div>
        @endif
    </div>

    <button type="submit" class="button">Save</button>
    <a class="button secondary" href="{{ route('projects.index') }}">Cancel</a>
</form>
