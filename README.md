# 🚀 Query Launcher | Support team

This project is for support team when they need execute a query from a database for some reason such as :

- Fetch a Book details by ref ID
- Create Factor for a book manually
- et

## How run it :

```sh
cd launcher
composer install
npm i
php artisan serve || valet link
```

AND DONE! 💪

## How it Works :

This app has two mode to work that user cant feel which one selected by developer!

how can i change mode? there is a config file. modes are two const that defined in <b style='color:#2980b9'>QueryController</b>.

in <b style='color:#2980b9'>Config/query.php</b>

1. Dynamic mode : <br>
- in this mode query structure will fetch from <b style='color:#2980b9'>dynamic-structure</b> property
- then makes form with
  <b style='color:#2980b9'>dynamic-query-dashboard.blade.php</b> (This blade handle query parameters with Alpine JS)
- <b style='color:#2980b9'>execute</b> method in <b style='color:#2980b9'>QueryController</b> depend on inputs and
  <b style='color:#2980b9'>dynamic-structure</b> runs a query.

description of config file : <br>
```
"dynamic-structure" => [
        "book" => [
            "selectRefundsByRefId" => [
                "show_as" => "Refund",
                "params" => [
                    [
                        "label" => "Ref ID",
                        "type" => "text",
                        "name" => "ref_id",
                        "priority" => 1,
                        "validation" => "required"
                    ]
                ],
                "response" => \Illuminate\Support\Collection::class,
            ],
            "findByRefId" => [
                "show_as" => "Fetch book by ref ID",
                "params" => [
                    [
                        "label" => "Ref ID",
                        "type" => "text",
                        "name" => "ref_id",
                        "priority" => 1,
                        "validation" => "required"
                    ]
                ],
                "response" => \Illuminate\Support\Collection::class
            ],
        ]
    ],
```
- each object of <b style='color:#2980b9'>dynamic-structure</b> defined <b style='color:#2980b9'>model class name</b>
- each object of <b style='color:#2980b9'>model class name</b> defined <b style='color:#2980b9'>scope method name</b>
- each method name object has 3 property :
- <b style='color:#2980b9'>show_as</b> : display title in combo box in <b style='color:#2980b9'>dynamic-query-dashboard.blade.php</b>
- <b style='color:#2980b9'>params</b> : each object in this array defined inputs (parameters)
- <b style='color:#2980b9'>response</b> : now if is null just returned success message otherwise returned collection

> in dynamic mode : define query methods in model as <b style='color:red'>SCOPE</b> & send parameter with an array like this ... ($params variable)

```
public function scopeFindByRefId($query,$params) {
    return $query->where('ref_id',$params[0]);
}
```

> 🔴 JUST DEFINE SCOPE METHOD AND SET CONFIGS! 🔴

[comment]: <> (## Plugins)

[comment]: <> (Dillinger is currently extended with the following plugins.)

[comment]: <> (Instructions on how to use them in your own application are linked below.)

[comment]: <> (| Plugin | README |)

[comment]: <> (| ------ | ------ |)

[comment]: <> (| Dropbox | [plugins/dropbox/README.md][PlDb] |)

[comment]: <> (| GitHub | [plugins/github/README.md][PlGh] |)

[comment]: <> (| Google Drive | [plugins/googledrive/README.md][PlGd] |)

[comment]: <> (| OneDrive | [plugins/onedrive/README.md][PlOd] |)

[comment]: <> (| Medium | [plugins/medium/README.md][PlMe] |)

[comment]: <> (| Google Analytics | [plugins/googleanalytics/README.md][PlGa] |)

## Disable Or Enable Features :

If you want desable / enable a feature or features of this project you can see
<b style='color:#2980b9'>fortify.php</b> and <b style='color:#2980b9'>jetstream.php</b> config files in <b style='color:#2980b9'>config</b> directory

fortify.php :

```sh
'features' => [
        Features::registration(),
        Features::resetPasswords(),
        Features::emailVerification(),
        Features::updateProfileInformation(),
        Features::updatePasswords(),
        Features::twoFactorAuthentication([
            'confirmPassword' => true,
        ]),
    ],
```

jetstream.php :

```sh
'features' => [
        Features::termsAndPrivacyPolicy(),
        Features::profilePhotos(),
        Features::api(),
        Features::teams(['invitations' => true]),
        Features::accountDeletion(),
    ],
```



[//]: # (These are reference links used in the body of this note and get stripped out when the markdown processor does its job. There is no need to format nicely because it shouldn't be seen. Thanks SO - http://stackoverflow.com/questions/4823468/store-comments-in-markdown-syntax)

[dill]: <https://github.com/joemccann/dillinger>
[git-repo-url]: <https://github.com/joemccann/dillinger.git>
[john gruber]: <http://daringfireball.net>
[df1]: <http://daringfireball.net/projects/markdown/>
[markdown-it]: <https://github.com/markdown-it/markdown-it>
[Ace Editor]: <http://ace.ajax.org>
[node.js]: <http://nodejs.org>
[Twitter Bootstrap]: <http://twitter.github.com/bootstrap/>
[jQuery]: <http://jquery.com>
[@tjholowaychuk]: <http://twitter.com/tjholowaychuk>
[express]: <http://expressjs.com>
[AngularJS]: <http://angularjs.org>
[Gulp]: <http://gulpjs.com>

[PlDb]: <https://github.com/joemccann/dillinger/tree/master/plugins/dropbox/README.md>
[PlGh]: <https://github.com/joemccann/dillinger/tree/master/plugins/github/README.md>
[PlGd]: <https://github.com/joemccann/dillinger/tree/master/plugins/googledrive/README.md>
[PlOd]: <https://github.com/joemccann/dillinger/tree/master/plugins/onedrive/README.md>
[PlMe]: <https://github.com/joemccann/dillinger/tree/master/plugins/medium/README.md>
[PlGa]: <https://github.com/RahulHP/dillinger/blob/master/plugins/googleanalytics/README.md>
