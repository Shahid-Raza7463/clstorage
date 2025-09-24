    <div class="form-group">
        <label>{{ ucwords(str_replace('_', ' ', $column)) }}</label>
        <input type="text" name="value" value="{{ $value }}" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
