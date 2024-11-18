@extends('common.admin.base')
@section('custom_css')
    @vite('resources/scss/admin/create.scss')
@endsection
@section('main_contents')
    <div class="page-wrapper edit-page-wrapper">
        <h2 class="title">ホテル編集</h2>
        <div class="form-wrapper">
            <form action="{{ route('adminHotelEditProcess', ['hotel_id' => $hotel->hotel_id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-item">
                    <label for="hotel_name">ホテル名</label>
                    <input type="text" name="hotel_name" value="{{ $hotel->hotel_name ?? old('hotel_name') }}" id="hotel_name" class="form-control">
                    @error('hotel_name')
                        <p class="error-message">{{ $errors->first('hotel_name') }}</p>
                    @enderror
                </div>
                <div class="form-item">
                    <label for="prefecture_id">都道府県</label>
                    <select name="prefecture_id" id="prefecture_id" class="form-control">
                        <option value="">選択してください</option>
                        @foreach ($prefectures as $prefecture)
                            <option value="{{ $prefecture->prefecture_id }}" {{ $hotel->prefecture_id == $prefecture->prefecture_id ? 'selected' : '' }}>{{ $prefecture->prefecture_name }}</option>
                        @endforeach
                    </select>
                    @error('prefecture_id')
                        <p class="error-message">{{ $errors->first('prefecture_id') }}</p>
                    @enderror
                </div>
                <div class="form-item">
                    <label for="file">画像</label>
                    <input type="file" name="file" id="file" value="{{ $hotel->file_path ?? old('file') }}" class="form-control" accept="image/*">
                    @if ($hotel->file_path)
                        <div class="current-image">
                            <p>画像:</p>
                            <img src="{{ asset('/assets/img/' . $hotel->file_path) }}" alt="Current Image" style="max-width: 200px; max-height: 200px;">
                        </div>
                    @endif
                    @error('file')
                        <p class="error-message">{{ $errors->first('file') }}</p>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">更新</button>
                <a href="{{ route('adminHotelSearchPage') }}" class="btn btn-secondary">戻る</a>
            </form>
        </div>
    </div>

@endsection 