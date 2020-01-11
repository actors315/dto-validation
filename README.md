# dto-validation
dto 较验

日常工作中，跟第三方系统对接是常有的事，而这些系统可能并不是同一种语言实现的，因为语言特性不同，总会遇到意想不到的事情。  
比如 php 是弱类型语言，'1'  与 1 是没有区别的，但是在 java 中，这两个就并不相同了。比如 null 与 '' 在 php 中也是相等的，但是在其他语言中，赋值就可能报错。  

这个库主要就是满足这些需要。

## 示例

```php

/**
 * @Validate # 是否需要较验
 * @var integer # 声明类型
 * @var integer autoConvert=integer # 声明类型，并且尝试自动转换
 * @Required() # 必须字段
 * @Required(default=1) # 字段必须，在字段为null的情况下设置默认值
 * @Enum(1,2,3) # 字段值必须为1,2,3中的一个
 */
```

## Note

为了更好的开发体验，强列建议安装 annotations 插件  
phpstorm(http://plugins.jetbrains.com/plugin/7320-php-annotations)
