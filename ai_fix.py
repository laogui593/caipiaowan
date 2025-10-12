#!/usr/bin/env python3
import os
from pathlib import Path
import openai
import datetime

# ---------------- 配置 ----------------
PROJECT_DIR = "/www/wwwroot/m668.hk/xn--168-f76i5o.hk"
OUTPUT_DIR = os.path.join(PROJECT_DIR, "ai_fix")
OVERWRITE = False
MODELS = ["gpt-5-codex", "gpt-5-mini", "gpt-3.5-turbo"]
TEMPERATURE = 0.2
MAX_TOKENS = 3000

openai.api_key = os.getenv("OPENAI_API_KEY")
if not openai.api_key:
    raise RuntimeError("请先设置 OPENAI_API_KEY 环境变量")

os.makedirs(OUTPUT_DIR, exist_ok=True)
log_file = os.path.join(OUTPUT_DIR, f"ai_fix_log_{datetime.datetime.now().strftime('%Y%m%d_%H%M%S')}.txt")

def log(msg):
    print(msg)
    with open(log_file, "a", encoding="utf-8") as f:
        f.write(msg + "\n")

py_files = list(Path(PROJECT_DIR).rglob("*.py"))
if not py_files:
    log("没有找到 Python 文件！")
    exit(0)

log(f"找到 {len(py_files)} 个 Python 文件，开始处理...")

for file_path in py_files:
    try:
        try:
            with open(file_path, "r", encoding="utf-8") as f:
                code = f.read()
        except Exception as e:
            log(f"[失败] {file_path.name} 读取文件失败: {e}")
            continue

        prompt = f"""
你是世界顶级 Python 编程 AI 助手。
请帮我检查下面的代码是否有错误或可以优化的地方，
修复报错并优化代码风格，保留原有功能。
请返回完整可运行的 Python 代码，并加上必要注释。

代码如下：
{code}
"""

        fixed_code = None
        for model in MODELS:
            try:
                response = openai.chat.completions.create(
                    model=model,
                    messages=[
                        {"role": "system", "content": "你是一个 Python 编程助手"},
                        {"role": "user", "content": prompt},
                    ],
                    temperature=TEMPERATURE,
                    max_tokens=MAX_TOKENS
                )
                fixed_code = response.choices[0].message.content
                log(f"[已使用模型] {model} 处理 {file_path.name}")
                break
            except openai.OpenAIError as e:
                if "model_not_found" in str(e):
                    log(f"[模型不可用] {model}，尝试下一个")
                else:
                    log(f"[失败] {file_path.name} 调用模型错误: {e}")
                    break

        if fixed_code is None:
            log(f"[失败] {file_path.name} 所有模型均不可用")
            continue

        output_file = file_path if OVERWRITE else Path(OUTPUT_DIR) / f"修复_{file_path.name}"
        try:
            with open(output_file, "w", encoding="utf-8") as f:
                f.write(fixed_code)
            log(f"[已处理] {file_path.name} -> {output_file}")
        except Exception as e:
            log(f"[失败] {file_path.name} 写入文件失败: {e}")

    except Exception as e:
        log(f"[失败] {file_path.name} 出现未知错误: {e}")

log("全部处理完成！")