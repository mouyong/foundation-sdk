<h1 align="center"> foundation-sdk </h1>

<p align="center"> .</p>


## Installing

```shell
$ composer require mouyong/foundation-sdk -vvv
```

## Usage

创建 Application 继承 Foundation，在 Application 类中，继承 $config、$provider 属性。

创建 Client 继承 AbstractClient。实现父类中的 sign 签名函数（如无签名直接返回数据）、request 函数发起 http 请求、castResponseToType 处理响应信息，并在 request 中调用 castResponseToType 函数。

在 castResponseToType 中，可以进行错误校验，数据提取等操作。

如果 api 需要 access_token 等信息。创建 AccessToken 继承 AbstractAccessToken 类。实现父类的相关函数。根据需要覆盖父类的相关属性。

创建相应的函数，并绑定到容器中。

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/mouyong/foundation-sdk/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/mouyong/foundation-sdk/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

LGPL