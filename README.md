# PHP-简单的练手项目
基于PHP搭建的简单的ACM判题系统，判题脚本使用python3编写。

主要实现了主页、题目列表、展示题目和提交问题答案的页面。

后端实现了简单的判题机制，能基本实现判断题目的正确与错误、或语法错误。

未实现安全隔离，用户提交的代码在服务端环境中直接运行，这是很危险的。

另外判题脚本的判题机制也很不合理，只能依据用户脚本的输出与预期输出是否一致来判断。但有的问题不止一个答案，像最小生成树之类的，需要验证用户的代码是否符合最小生成树的定义。总之，判题机制很不合理。
