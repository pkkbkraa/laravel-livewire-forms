# 建立表單元件

使用 `make` 命令：

```php
php artisan make:form UserCreateForm --model=User
```

這將在 `app/Http/Livewire` 資料夾中建立新的表單元件。

建立元件後，您可能希望編輯 `fields`、`success`、`saveAndStayResponse` 和 `saveAndGoBackResponse` 方法：

```php
class UserCreateForm extends FormComponent
{
    public function fields()
    {
        return [
            Field::make('Name')->input()->rules('required'),
        ];
    }

    public function success()
    {
        User::create($this->form_data);
    }

    public function saveAndStayResponse()
    {
        return redirect()->route('users.create');
    }

    public function saveAndGoBackResponse()
    {
        return redirect()->route('users.index');
    }
}
```

您無需在表單元件中使用 `render()` 方法，也不需要擔心元件視圖，因為該套件會自動處理。

**小提示：您可以為您的 `Model` 添加 `FillsColumns` trait，以便通過數據庫列名自動填充 `$fillable`。**

# 使用表單元件

您可以像使用任何其他 Livewire 元件一樣在視圖中使用表單元件：

```html
@livewire('user-create-form')
```

現在，您只需更新您的表單元件類別！

# 表單元件屬性

### `$model`

可選的 [Eloquent](https://laravel.com/docs/master/eloquent) 模型實例，附加到表單元件。這通過 `@livewire` Blade 指示來傳遞。

示例：

```html
@livewire('user-edit-form', ['model' => $user])
```

在元件的 `success` 方法中使用模型的例子：

```php
public function success()
{
    $this->model->update($this->form_data);
}
```

### `$form_data`

包含表單中當前數據的陣列。該數據以每個字段名為鍵。

示例：

```php
$name = $this->form_data['name'];
```

### `$storage_disk`

靜態屬性，用於設置文件上傳的磁碟。默認為 `public`。

示例：

```php
private static $storage_disk = 's3';
```

或者，通過 `.env` 文件全局應用：

```ini
FORM_STORAGE_DISK="s3"
```

### `$storage_path`

靜態屬性，用於設置文件上傳的路徑。默認為 `uploads`。

示例：

```php
private static $storage_path = 'avatars';
```

或者，通過 `.env` 文件全局應用：

```ini
FORM_STORAGE_PATH="avatars"
```

# 表單元件方法

### `fields()`

此方法返回一個 `Field` 陣列，用於表單中的字段。

示例：

```php
public function fields()
{
    return [
        Field::make('Name')->input()->rules('required'),
        Field::make('Email')->input('email')->rules(['required', 'email', 'unique:users,email']),
        Field::make('Password')->input('password')->rules(['required', 'min:8', 'confirmed']),
        Field::make('Confirm Password', 'password_confirmation')->input('password'),
    ];
}
```

聲明 `Field` 類似於聲明 Laravel Nova 字段。[跳轉到字段聲明部分](#表單字段聲明) 以了解更多信息。

### `rulesIgnoreRealtime()`

此方法用於設置在實時驗證期間要忽略的規則。

示例：

```php
public function rulesIgnoreRealtime()
{
    return ['confirmed', new MyCustomRule];
}
```

### `success()`

此方法定義了在表單成功提交且驗證通過時應執行的操作。

示例：

```php
public function success()
{
    $this->form_data['password'] = Hash::make($this->form_data['password']);

    User::create($this->form_data);
}
```

### `saveAndStayResponse()`

此方法定義了通過 `Save` 按鈕成功提交後的響應。

示例：

```php
public function saveAndStayResponse()
{
    return redirect()->route('users.edit', $this->model->id);
}
```

### `saveAndGoBackResponse()`

此方法定義了通過 `Save & Go Back` 按鈕成功提交後的響應。

示例：

```php
public function saveAndGoBackResponse()
{
    return redirect()->route('users.index');
}
```

### `mount($model = null)`

此方法設置了初始表單屬性。如果您需要覆蓋它，請確保調用 `$this->setFormProperties()`。

##### `$model`

傳遞給表單元件的模型實例。

示例：

```php
public function mount($model = null)
{
    $this->setFormProperties();
    
    // 自定義代碼
}
```

### `render()`

此方法渲染表單元件視圖。如果您需要覆蓋它，請確保 `return $this->formView()`。

示例：

```php
public function render()
{
    // 自定義代碼
    
    return $this->formView();
}
```

# 表單字段聲明

`Field` 類用於聲明表單字段。

```php
public function fields()
{
    $brand_options = Brand::orderBy('name')->get()->pluck('id', 'name')->all();

    return [
        Field::make('Brand', 'brand_id')->select($brand_options)->help('請選擇一個品牌。'),
        Field::make('Name')->input()->rules(['required', Rule::unique('cars', 'name')->ignore($this->model->id)]),
        Field::make('Photos')->file()->multiple()->rules('required'),
        Field::make('Color')->select(['Red', 'Green', 'Blue']),
        Field::make('Colors')->multipleSelect(['Red', 'Green', 'Blue']),
        Field::make('Owners')->array([
            ArrayField::make('Name')->input()->placeholder('姓名')->rules('required'),
            ArrayField::make('Phone')->input('tel')->placeholder('電話')->rules('required'),
        ])->rules('required'),
        Field::make('Insurable')->checkbox()->placeholder('車輛是否可投保？')->rules('accepted'),
        Field::make('Insurable')->switch()->placeholder('車輛是否可投保？')->rules('accepted'),
        Field::make('Fuel Type')->radio(['Gas', 'Diesel', 'Electric'])->default('Diesel'),
        Field::make('Features')->checkboxes(['Stereo', 'Bluetooth', 'Navigation'])->rules('required|min:2'),
        Field::make('Description')->textarea(),
    ];
}
```

### `make($label, $name = null)`

##### `$label`

用於表單字段的標籤，例如 `名字`。

##### `$name`

用於表單字段的名稱。如果為 null，則將使用蛇形命名的 `$label`。

基本字段示例：

```php
Field::make('名字')->input()->rules('required|min:2'),
```

關聯字段示例：

```php
$brand_options = Brand::orderBy('name')->get()->pluck('id', 'name')->all();

return [
    Field::make('品牌', 'brand_id')->select($brand_options)->rules(['required', Rule::exists('brands', 'id')]),
    // ...
```

### `input($type = 'text')`

將字段設置為 `input` 元素。默認為 `text`。

##### `$type`

用於 input 的可選 HTML5 input 類型。

示例：

```php
Field::make('email')->input('email'),
```

### `file()`

將字段設置為 `file` input 元素。

文件字段應該有一個可為 null 的 `text` 數據庫列，在模型中應該轉換為 `array`。
這個數組將包含每個文件的有用信息，包括 `file`、`disk`、`name`、`size` 和 `mime_type`。

示例遷移：

```php
$table->text('photos')->nullable();
```

示例模型轉換：

```php
protected $casts = ['photos' => 'array'];
```

示例字段聲明：

```php
Field::make('photos')->file(),
```

您可以使用 `multiple()` 方法允許多個文件選擇：

```php
Field::make('photos')->file()->multiple(),
```

### `textarea($rows = 2)`

將字段設置為 `textarea` 元素。

##### `$rows`

文本區域的行數。默認為 `2`。

示例：

```php
Field::make('description')->textarea(5),
```

### `select($options = [])`

將字段設置為 `select` 下拉元素。

##### `$options`

用於下拉選項的陣列。

示例使用連續陣列：

```php
Field::make('Color')->select(['紅色', '綠色', '藍色']),
```

示例使用關聯陣列：

```php
Field::make('Color')->select(['紅色' => '#ff0000', '綠色' => '#00ff00', '藍色' => '#0000ff']),
```

使用關聯陣列時，鍵將用於選項標籤，值用於選項值。

### `multipleSelect($options = [])`
將字段設置為 `select` 下拉元素，並設置成多選，用法與 `select` 相同。

### `checkbox()`

將字段設置為 `checkbox` 元素。

勾選框字段應該有一個可為 null 的 `boolean` 數據庫列。

示例遷移：

```php
$table->boolean('accepts_terms')->nullable();
```

示例字段聲明：

```php
Field::make('accepts_terms')->checkbox()->placeholder('您是否接受我們的服務條款？')->rules('accepted'),
```

如果指定了 `placeholder()`，則將用作勾選框的標籤。

### `switch()`

將字段設置為 `checkbox` 元素，但以 `switch buttom` 呈現。

### `checkboxes($options = [])`

將字段設置為多個 `checkbox` 元素。

##### `$options`

用於勾選框的選項陣列。與 `select()` 方法的使用方式相同。

勾選框字段應該有一個可為 null 的 `text` 數據庫列，在模型中應該轉換為 `array`。

示例遷移：

```php
$table->text('features')->nullable();
```

示例模型轉換：

```php
protected $casts = ['features' => 'array'];
```

示例字段聲明：

```php
Field::make('features')->checkboxes(['音響', '藍牙', '導航'])->rules('required|min:2'),
```

### `radio($options = [])`

將字段設置為 `radio` 元素。

##### `$options`

用於單選按鈕的選項陣列。與 `select()` 方法的使用方式相同。

示例：

```php
Field::make('燃料類型', 'fuel_type')->radio(['汽油', '柴油', '電動'])->default('柴油'),
```

### `array($fields = [])`

將字段設置為字段的數組。

##### `$fields`

用於的 `ArrayField` 陣列。[跳轉到數組字段聲明部分](#數組字段聲明) 以獲取更多信息。

示例：

```php


Field::make('Owner')->array([
    ArrayField::make('full_name')->input()->placeholder('全名')->rules('required'),
    ArrayField::make('phone_number')->input('tel')->placeholder('電話號碼'),
])->rules('required'),
```

使用 `sortable()` 方法使數組字段可排序：

```php
Field::make('Owner')->array([
    ArrayField::make('full_name')->input()->placeholder('全名')->rules('required'),
    ArrayField::make('phone_number')->input('tel')->placeholder('電話號碼'),
])->sortable(),
```

### `default($default)`

設置字段的默認值。

##### `$default`

默認值。

示例：

```php
Field::make('City')->input()->default('台北'),
```

### `autocomplete($autocomplete)`

設置字段的自動完成值。

##### `$autocomplete`

自動完成值。

示例：

```php
Field::make('密碼', 'password')->input('password')->autocomplete('new-password'),
```

### `placeholder($placeholder)`

設置字段的佔位符值。

##### `$placeholder`

佔位符值。

示例：

```php
Field::make('國家', 'country')->input()->placeholder('您所在的國家是？'),
```

### `help($help)`

設置字段下方的幫助文本。

##### `$help`

幫助文本。

示例：

```php
Field::make('城市', 'city')->input()->help('請輸入您目前所在的城市。'),
```

### `rules($rules)`

設置字段的 [Laravel 驗證規則](https://laravel.com/docs/master/validation#available-validation-rules)。

##### `$rules`

用於字段的 Laravel 驗證規則的字符串或陣列。

示例使用字符串：

```php
Field::make('name')->input()->rules('required|min:2'),
```

示例使用陣列：

```php
Field::make('city')->input()->rules(['required', Rule::in(['台北', '高雄']), new MyCustomRule]),
```

### `view($view)`

設置自定義視圖來使用字段。對於套件中未包含的更複雜的字段元素很有用。

##### `$view`

自定義視圖。

示例自定義視圖文件：

```html
{{-- fields/custom-field.blade.php --}}
<div class="form-group row">
    <label for="{{ $field->name }}" class="col-md-2 col-form-label text-md-right">
        {{ $field->label }}
    </label>

    <div class="col-md">
        <input
            id="{{ $field->name }}"
            type="text"
            class="custom-field-class form-control @error($field->key) is-invalid @enderror"
            wire:model.lazy="{{ $field->key }}">

        @include('laravel-livewire-forms::fields.error-help')
    </div>
</div>
```

自定義視圖將傳遞 `$field`、`$form_data` 和 `$model` 變數，以及任何其他公共元件屬性。

示例自定義視圖字段聲明：

```php
Field::make('custom')->view('fields.custom-field');
```

# 數組字段聲明

`ArrayField` 與 `Field` 略有不同。它們只能在字段的 `array()` 方法內聲明。
它們具有大多數相同的可用方法，但不包括 `file()` 和 `array()` 方法。
它們還有一個 `columnWidth()` 方法，`Field` 沒有此方法。

### `make($name)`

##### `$name`

用於數組字段的名稱，例如 `phone_number`。
數組字段不使用標籤，而應該為它們指定一個 `placeholder()`。

示例：

```php
ArrayField::make('phone_number')->input('tel')->placeholder('電話號碼')->rules('required'),
```

### `columnWidth($width)`

可選的 [Bootstrap 4 grid](https://getbootstrap.com/docs/4.4/layout/grid/) 框架列寬，用於桌面上的數組字段。
如果未設置此項，則默認情況下該列將均勻地適應網格。

示例：

```php
ArrayField::make('province')->select(['AB', 'BC', 'ON'])->placeholder('省份')->columnWidth(4),
```

您還可以使用 `auto` 使列自動適應數組字段寬度：

```php
ArrayField::make('old_enough')->checkbox()->placeholder('年齡足夠')->columnWidth('auto'),
```

# 發佈檔案

發佈文件是可選的。

發佈表單視圖文件：

```php
php artisan vendor:publish --tag=form-views
```

發佈配置文件：

```php
php artisan vendor:publish --tag=form-config
```
