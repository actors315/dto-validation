# dto-validation
以注解的方式实现的验证器

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
 public $property;

```
